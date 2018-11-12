<?php

namespace App\Console\Commands\Helper;

use App\Helper\HttpHelper;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Helper\CurlMultiHelper;
use Ares333\Curl\Toolkit;

class BookHelper
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public static function run()
    {
        $category = Category::all(['id', 'url'])->toArray();
        $category_with_urls = array_combine(array_column($category, 'url'), array_column($category, 'id'));

        $tookit = new Toolkit();
        $book_urls = CurlMultiHelper::get(array_keys($category_with_urls), function ($ql, $curl, $r) use ($tookit) {
            $url1 = (array) $ql->find('#hotcontent .ll .item')->map(function ($item) use ($tookit, $r) {
                return $tookit->uri2url($item->find('.image a')->attr('href'), $r['info']['url']);
            })->flatten()->all();

            $url2 = (array) $ql->find('#newscontent .r li, #newscontent .l li')->map(function ($item) use ($tookit, $r) {
                return $tookit->uri2url($item->find('.s2 a')->attr('href'), $r['info']['url']);
            })->flatten()->all();

            return array_merge($url1, $url2);
        });

        foreach ($book_urls as $key => $url) {
            // 当前分类下的书本数量
            $category_book_number = count($url);
            $current_book = 0;

            $category_id = $category_with_urls[$key];
            CurlMultiHelper::get($url, function ($ql, $curl, $r) use ($tookit, $category_id, $category_book_number, &$current_book) {

                $current_book++;
                $temp['title'] = trim($ql->find('#info h1')->text());
                $temp['author'] = $ql->find('#info p:eq(0)')->text();
                $temp['author'] = preg_replace('/作(\s|(&nbsp;))*者(\:|：)/su', '', $temp['author']);
                $temp['author'] = trim($temp['author']);
                $temp['last_update'] = $ql->find('#info p:eq(2)')->text();
                $temp['last_update'] = preg_replace('/[\x{4e00}-\x{9fa5}]*：/suU', '', $temp['last_update']);
                $temp['description'] = $ql->find('#intro')->html();
                $temp['image_local_url'] = '';
                $temp['image_origin_url'] = $ql->find('#fmimg > img')->attr('src');
                $temp['url'] = $r['info']['url'];
                $temp['category_id'] = $category_id;
                $temp['author_id'] = Author::getAuthorId($temp['author']);
                $temp['finished'] = $ql->find('#info p:eq(1)')->text();
                $temp['finished'] = mb_strrpos($temp['finished'], '已完结') !== false ? 1 : 0;
                $temp['view'] = 0;
                $temp['newest_chapter'] = '';
                $temp['unique_code'] = md5($temp['author'] . $temp['title']);
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');

                // 下载生成图片
                $temp = self::getBookImages($temp);

                // 如果该书可以抓取，并且数据库中没有该书，则做入库操作
                $book = Book::where('unique_code', $temp['unique_code'])->first();
                if (empty($book)) {
                    echo "当前分类：{$category_id}, 该分类书籍：{$current_book} / {$category_book_number}, 书名: 《{$temp['title']}》 URL：{$temp['url']} 入库\n";
                    Book::insert($temp);
                } else {
                    if ($book->category_id != $book->category_id) {
                        echo "该书已存在！更新 category_id {$book->category_id} to {$category_id}\n";
                        $book->category_id = $category_id;
                    } else {
                        echo "当前分类：{$category_id}, 该分类书籍：{$current_book} / {$category_book_number}, 书名: 《{$temp['title']}》 已经存在！！！\n";
                    }
                    $book->last_update = $temp['last_update'];
                    $book->author_id = $temp['author_id'];
                    $book->finished = $temp['finished'];
                    $book->save();
                }

                return $temp;
            });
        }

        return null;
    }

    public static function getBookImages($book)
    {
        $save_dir = public_path('images/author/');
        $save_db_path = '/images/author/';
        if (! file_exists($save_dir)) {
            mkdir($save_dir, 0766, true);
        }

        $ext = substr($book['image_origin_url'], strrpos($book['image_origin_url'], '.'));
        if (empty($ext)) {
            $ext = '.jpg';
        }
        $full_path = $save_dir . $book['unique_code'] . $ext;
        $db_full_path = $save_db_path . $book['unique_code'] . $ext;
        $book['image_local_url'] = '';
        if (! empty($book['image_origin_url']) && ! file_exists($full_path)) {
            $content = HttpHelper::send($book['image_origin_url']);
            if ($content) {
                @file_put_contents($full_path, $content);
                $book['image_local_url'] = $db_full_path;
            }
        }

        return $book;
    }
}
