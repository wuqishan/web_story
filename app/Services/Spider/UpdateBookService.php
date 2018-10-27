<?php

namespace App\Services\Spider;


use App\Models\Author;
use App\Models\Book;
use App\Models\CheckBookInfo;

class UpdateBookService extends SpiderService
{

    public $calc_book = 0;
    /**
     * 传入book列表的url，更新book数据
     *
     * @param $category_id
     * @param $book_url
     */
    public function getBook($category_id, $book_url)
    {
        $ql = $this->spider($book_url);
        $urls = [];

        // 上面的6条
        $ql->find('#hotcontent .ll .item')->map(function ($item) use (& $urls) {
            $urls[] = $item->find('.image a')->attr('href');
            return $item;
        });

        // 下方左侧的数据
        $ql->find('#newscontent .l ul li')->map(function ($item) use (& $urls) {
            $urls[] = $item->find('.s2 a')->attr('href');
            return $item;
        });

        // 下方右侧的数据
        $ql->find('#newscontent .r ul li')->map(function ($item) use (& $urls) {
            $urls[] = $item->find('.s2 a')->attr('href');
            return $item;
        });

        if (! empty($urls)) {
            foreach ($urls as $url) {
                $this->getBookDetail($url, $category_id);
            }
            echo "此次入库书籍 {$this->calc_book} 本\n";
        }
    }

    /**
     * 获取详细页content
     *
     * @param $url
     * @return string
     */
    public function getBookDetail($url, $category_id)
    {
        $url = $this->urlJoin($url);
        $ql = $this->spider($url);

        $temp['title'] = trim($ql->find('#info h1')->text());
        $temp['author'] = $ql->find('#info p:eq(0)')->text();
        $temp['author'] = preg_replace('/作(\s|(&nbsp;))*者(\:|：)/su', '', $temp['author']);
        $temp['author'] = trim($temp['author']);
        $temp['last_update'] = $ql->find('#info p:eq(2)')->text();
        $temp['last_update'] = preg_replace('/[\x{4e00}-\x{9fa5}]*：/suU', '', $temp['last_update']);
        $temp['description'] = $ql->find('#intro')->html();
        $temp['image_local_url'] = '';
        $temp['image_origin_url'] = $ql->find('#fmimg > img')->attr('src');
        $temp['url'] = $url;
        $temp['category_id'] = $category_id;
        $temp['author_id'] = $this->getAuthorId($temp['author']);
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
                echo "Title: {$temp['title']} 入库,目前已有 {$this->calc_book} 本新书入库\n";
                Book::insert($temp);
                $this->calc_book++;
            }
        }
    }

    /**
     * 根据作者名称获取作者的id
     *
     * @param $author_name
     * @return integer
     */
    public function getAuthorId($author_name)
    {
        $author_id = 0;
        if (! empty($author_name)) {
            $author = Author::where('name', $author_name)->first();
            if (! empty($author)) {
                $author_id = $author->id;
            }
        }

        return $author_id;
    }
}