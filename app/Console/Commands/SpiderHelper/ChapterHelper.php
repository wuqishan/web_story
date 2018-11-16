<?php

namespace App\Console\Commands\SpiderHelper;

use App\Helper\CurlMultiHelper;
use App\Models\NewBook;
use App\Models\NewChapter;
use Ares333\Curl\Toolkit;

class ChapterHelper
{
    public function run()
    {
        $books = NewBook::where('finished', 0)
            ->select(['id', 'unique_code', 'category_id', 'newest_chapter', 'url'])
            ->get()
            ->toArray();

        $books_new = [];
        foreach ($books as $book) {
            $value = "{$book['id']}-{$book['unique_code']}-{$book['category_id']}-{$book['newest_chapter']}";
            $books_new[$book['url']] = $value;
        }

        // 当前抓取第几本书籍和一共有多少本数据待抓取
        $book_current = 0;
        $book_number = count($books_new);
        $tookit = new Toolkit();
        CurlMultiHelper::get(array_keys($books_new), function ($ql, $curl, $r) use ($tookit, $books_new, $book_number, &$book_current) {

            // 当前抓取第几本书籍
            $book_current++;
            $book_author = $ql->find('#info p:eq(0)')->text();
            $book_author = preg_replace('/作(\s|(&nbsp;))*者(\:|：)/su', '', $book_author);
            $book_author = trim($book_author);
            $book_title = trim($ql->find("#info > h1")->text());

            // 获取书本信息
            $book_info = $books_new[$r['info']['url']];
            list($book_id, $book_unique_code, $category_id) = explode('-', $book_info);

            $chapter_sub_info = (array) $ql->find('#list dl dd')->map(function ($item) use ($tookit, $r) {
                $temp['url'] = $tookit->uri2url($item->find('a')->attr('href'), $r['info']['url']);
                $temp['title'] = trim($item->find('a')->text());
                return $temp;
            });
            $chapter_sub_info = array_pop($chapter_sub_info);     // 去除一层数组
            $length = count($chapter_sub_info);                         // 获取长度
            foreach ($chapter_sub_info as $key => $val) {

                $temp['book_unique_code'] = $book_unique_code;
                // 作者 + 书名 + 章节名 + 排序key
                $temp['unique_code'] = md5($book_author . $book_title . $val['title'] . $key);
                $temp['title'] = $val['title'];
                $temp['view'] = 0;
                $temp['url'] = $val['url'];
                $temp['orderby'] = $key;
                $temp['category_id'] = $category_id;
                $temp['is_new'] = 1;
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');

                try {
                    if ($key === 0 && $key === $length - 1) {
                        $temp['prev_unique_code'] = '';
                        $temp['next_unique_code'] = '';
                    } else if ($key === 0) {
                        $temp['prev_unique_code'] = '';
                        $temp['next_unique_code'] = md5($book_author . $book_title . $chapter_sub_info[$key + 1]['title'] . ($key + 1));
                    } else if ($key === $length - 1) {
                        $temp['next_unique_code'] = '';
                        $temp['prev_unique_code'] = md5($book_author . $book_title . $chapter_sub_info[$key - 1]['title'] . ($key - 1));
                    } else {
                        $temp['prev_unique_code'] = md5($book_author . $book_title . $chapter_sub_info[$key - 1]['title'] . ($key - 1));
                        $temp['next_unique_code'] = md5($book_author . $book_title . $chapter_sub_info[$key + 1]['title'] . ($key + 1));
                    }

                    // 插入章节
                    NewChapter::insert($temp);

                    // 更新book最新更新的章节
                    if ($key === $length - 1) {
                        NewBook::where('id', $book_id)->update(['newest_chapter' => $temp['unique_code']]);
                    }

                    echo "进度：{$book_number} / {$book_current}, category_id: {$category_id}, title: {$temp['title']}, Url: {$temp['url']}\n";
                } catch (\Exception $e) {
                    // todo something
                }
            }
        });

        return null;
    }
}
