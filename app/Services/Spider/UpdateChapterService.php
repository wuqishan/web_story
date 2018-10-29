<?php

namespace App\Services\Spider;


use App\Helper\ToolsHelper;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterContent;
use Illuminate\Support\Facades\DB;

class UpdateChapterService extends SpiderService
{
    /**
     * 传入book的url，更新该book的章节数据
     *
     * @param $book_url
     * @param $newest_chapter
     * @param $category_id
     */
    public function getChapter($book_url, $newest_chapter, $category_id)
    {
        $ql = $this->spider($book_url);

        $book_title = trim($ql->find('#info h1')->text());
        $book_author = $ql->find('#info p:eq(0)')->text();
        $book_author = preg_replace('/作(\s|(&nbsp;))*者(\:|：)/su', '', $book_author);
        $book_author = trim($book_author);

        $data = $ql->find('#list dl dd')->map(function ($item) {
            $temp['url'] = $item->find('a')->attr('href');
            $temp['title'] = trim($item->find('a')->text());
            $temp['url'] = $this->urlJoin($temp['url']);
            return $temp;
        });
        $new_chapter = 0;
        if (! empty($data)) {
            $run_at = false;
            $length = count($data);
            foreach ($data as $k => $v) {
                $temp['book_unique_code'] = md5($book_author . $book_title);
                $temp['unique_code'] = md5($book_author . $book_title . $v['title']);
                $temp['title'] = $v['title'];
                $temp['view'] = 0;
                $temp['url'] = $v['url'];
                $temp['orderby'] = $k;
                $temp['category_id'] = $category_id;
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');
                if ($k === 0) {
                    $temp['prev_unique_code'] = '';
                    $temp['next_unique_code'] = md5($book_author . $book_title . $data[$k + 1]['title']);
                } else if ($k === $length - 1) {
                    $temp['next_unique_code'] = '';
                    $temp['prev_unique_code'] = md5($book_author . $book_title . $data[$k - 1]['title']);
                } else {
                    $temp['prev_unique_code'] = md5($book_author . $book_title . $data[$k - 1]['title']);
                    $temp['next_unique_code'] = md5($book_author . $book_title . $data[$k + 1]['title']);
                }

                // 跳过前面已经有的章节
                if (! empty($newest_chapter)) {
                    if (! $run_at) {
                        if ($newest_chapter == $temp['unique_code']) {
                            $this->updateNextUniqueCode($temp);
                            echo "更新当前章节的下一章节唯一码\n";
                            $run_at = true;

                        }
                        continue;
                    }
                }

                // 更新book最新更新的章节
                if ($k === $length - 1) {
                    Book::where('unique_code', $temp['book_unique_code'])->update(['newest_chapter' => $temp['unique_code']]);
                }
                $content['content'] = $this->getContent($temp['url']);
                $temp['number_of_words'] = ToolsHelper::calcWords($content['content']);


                DB::table('chapter_' . $category_id)->insertGetId($temp);
//                $chapterModel->setTable($category_id);
//                $content['id'] = $chapterModel->insertGetId($temp);
                $content['id'] = DB::table('chapter_' . $category_id)->insertGetId($temp);
                DB::table('chapter_content_' . $category_id)->insert($content);

                echo "id = {$content['id']}, category_id = {$category_id}, 当前爬取 《{$book_title}》 的 （{$temp['title']}）；目前该书新增 " . (++$new_chapter) . "章\n";
            }
        }
    }

    /**
     * 获取详细页content
     *
     * @param $url
     * @return string
     */
    public function getContent($url)
    {
        $ql = $this->spider($url);
        $content = $ql->find('#content')->html();

        return '<div id="content">' . $content . '</div>';
    }

    /**
     * 更新数据的下一章unique code
     *
     * @param $record
     * @return bool
     */
    public function updateNextUniqueCode($record)
    {
        if (! empty($record['next_unique_code'])) {
            DB::table('chapter_' . $record['category_id'])->where('unique_code', $record['unique_code'])->update(['next_unique_code' => $record['next_unique_code']]);

        }

        return true;
    }
}