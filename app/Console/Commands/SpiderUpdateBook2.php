<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\CheckBookInfo;
use Illuminate\Console\Command;
use App\Helper\CurlMultiHelper;
use Ares333\Curl\Toolkit;

class SpiderUpdateBook2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-book2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取小说书本信息';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $category_with_urls = [
            'https://www.xbiquge6.com/xclass/1/1.html' => 1,
            'https://www.xbiquge6.com/xclass/2/1.html' => 2,
            'https://www.xbiquge6.com/xclass/3/1.html' => 3,
            'https://www.xbiquge6.com/xclass/4/1.html' => 4,
            'https://www.xbiquge6.com/xclass/5/1.html' => 5,
            'https://www.xbiquge6.com/xclass/6/1.html' => 6,
            'https://www.xbiquge6.com/xclass/7/1.html' => 7
        ] ;

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
                $temp['author_id'] = $this->_getAuthorId($temp['author']);
                $temp['view'] = 0;
                $temp['newest_chapter'] = '';
                $temp['unique_code'] = md5($temp['author'] . $temp['title']);
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');

                // 已经删除的数据，后面再次爬取则跳过
                $delete_book_unique_code_str = [];
                $delete_books = CheckBookInfo::where('status', 1)->where('method', 2)->get();
                if (! empty($delete_books)) {
                    $delete_books = $delete_books->toArray();
                    $delete_book_unique_code_str = array_column($delete_books, 'book_unique_code');
                }
                $delete_book_unique_code_str = ','. implode(',', $delete_book_unique_code_str) .',';

                // 如果该书可以抓取，并且数据库中没有该书，则做入库操作
                if (strpos($delete_book_unique_code_str, $temp['unique_code']) !== true) {
                    $book = Book::where('unique_code', $temp['unique_code'])->first();
                    if (empty($book)) {
                        echo "当前分类：{$category_id}, 该分类书籍：{$current_book} / {$category_book_number}, 书名: 《{$temp['title']}》 URL：{$temp['url']} 入库\n";
                        Book::insert($temp);
                    } else {
                        if ($book->category_id != $book->category_id) {
                            echo "该书已存在！更新 category_id {$book->category_id} to {$category_id}\n";
                            $book->category_id = $category_id;
                            $book->save();
                        }else {
//                            echo "当前分类：{$category_id}, 该分类下书籍：{$category_book_number}, 当前为第 {$current_book}, 书名: 《{$temp['title']}》 已经存在！！！\n";
                        }
                    }
                }

                return $temp;
            });
        }
    }

    private function _getAuthorId($author_name)
    {
        $author_id = 0;
        if (! empty($author_name)) {
            $author = Author::where('name', $author_name)->first();
            if (! empty($author)) {
                $author_id = $author->id;
            } else {
                Author::insert(['name' => $author_name]);
            }
        }

        return $author_id;
    }
}
