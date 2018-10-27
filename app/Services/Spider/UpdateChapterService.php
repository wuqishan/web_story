<?php

namespace App\Services\Spider;


use App\Models\Book;
use App\Models\Chapter;

class UpdateChapterService extends SpiderService
{
    /**
     * 传入book的url，更新该book的章节数据
     *
     * @param $book_url
     * @param string $newest_chapter
     */
    public function getChapter($book_url, $newest_chapter = '')
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
                            echo "更新next code";
                            $run_at = true;

                        }
                        continue;
                    }
                }
                $temp['content'] = $this->getContent($temp['url']);
                $temp['content'] = mb_substr($temp['content'], 0, 30);

                // 更新book最新更新的章节
                if ($k === $length - 1) {
                    Book::where('unique_code', $temp['book_unique_code'])->update(['newest_chapter' => $temp['unique_code']]);
                }

                Chapter::insert($temp);
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
            Chapter::where('unique_code', $record['unique_code'])->update(['next_unique_code' => $record['next_unique_code']]);
        }

        return true;
    }
}