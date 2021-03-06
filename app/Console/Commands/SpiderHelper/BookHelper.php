<?php

namespace App\Console\Commands\SpiderHelper;

use App\Helper\HttpHelper;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookDeleted;
use App\Models\Category;
use App\Helper\CurlMultiHelper;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Ares333\Curl\Toolkit;

class BookHelper
{
    /**
     * @return array
     */
    public function run()
    {
        // 清空临时表
        NewBook::truncate();
        NewChapter::truncate();
        NewChapterContent::truncate();

        $category = Category::all(['id', 'url'])->toArray();
        $category_with_urls = array_combine(array_column($category, 'url'), array_column($category, 'id'));

//        $category_with_urls = [
//            'https://www.xbiquge6.com/xclass/1/1.html' => 1,
//            'https://www.xbiquge6.com/xclass/2/1.html' => 2,
//            'https://www.xbiquge6.com/xclass/3/1.html' => 3,
//            'https://www.xbiquge6.com/xclass/4/1.html' => 4,
//            'https://www.xbiquge6.com/xclass/5/1.html' => 5,
//            'https://www.xbiquge6.com/xclass/6/1.html' => 6,
//            'https://www.xbiquge6.com/xclass/7/1.html' => 7
//        ];

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

        // 目前所有书本的url
        $bookExists = Book::all(['url']);
        if (! empty($bookExists)) {
            $bookExists = $bookExists->toArray();
            $bookExists = array_column($bookExists, 'url');
        }
        // 目前所有删除的书本url
        $bookDeletedExists = BookDeleted::all(['url']);
        if (! empty($bookDeletedExists)) {
            $bookDeletedExists = $bookDeletedExists->toArray();
            $bookDeletedExists = array_column($bookDeletedExists, 'url');
        }
        $bookAllUrlExists = array_merge((array) $bookExists, (array) $bookDeletedExists);
        
        if (! empty($bookAllUrlExists)) {
            foreach ($book_urls as $key => $val) {

                $temp = array_diff($val, $bookAllUrlExists);
                if (! empty($temp)) {
                    $book_urls[$key] = $temp;
                } else {
                    unset($book_urls[$key]);
                }
            }
        }

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
                $temp['number_of_words'] = 0;
                $temp['unique_code'] = md5($temp['author'] . $temp['title']);
                $temp['is_new'] = 1;
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');

                // 下载生成图片
                $temp = $this->getBookImages($temp);

                // 如果该书可以抓取，并且数据库中没有该书，则做入库操作
                $book = NewBook::where('unique_code', $temp['unique_code'])->first();
                if (empty($book)) {
                    NewBook::insert($temp);
                    echo "当前分类：{$category_id}, 该分类书籍：{$current_book} / {$category_book_number}, 书名: 《{$temp['title']}》 URL：{$temp['url']} 入库\n";
                }

                return $temp;
            });
        }

        return null;
    }

    public function getBookImages($book)
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
        } else {
            $book['image_local_url'] = $db_full_path;
        }

        return $book;
    }
}
