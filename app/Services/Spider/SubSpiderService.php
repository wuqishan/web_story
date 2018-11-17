<?php

namespace App\Services\Spider;

use App\Console\Commands\SpiderHelper\BookHelper;
use App\Helper\ToolsHelper;
use App\Models\Author;
use App\Models\Book;
use App\Models\CheckBookInfo;

class SubSpiderService extends SpiderService
{
    /**
     * 返回文章的内容和字数
     *
     * @param $url
     * @return array
     */
    public function getContent($url)
    {
        $ql = $this->spider($url);

        $content = $ql->find('#content')->html();
        $content = '<div id="content">' . $content . '</div>';
        $number_of_words = ToolsHelper::calcWords($content);

        return [$content, $number_of_words];
    }

    public function getBook($url, $category_id)
    {
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
        $temp['author_id'] = Author::getAuthorId($temp['author']);
        $temp['view'] = 0;
        $temp['is_new'] = 1;
        $temp['newest_chapter'] = '';
        $temp['unique_code'] = md5($temp['author'] . $temp['title']);
        $temp['created_at'] = date('Y-m-d H:i:s');
        $temp['updated_at'] = date('Y-m-d H:i:s');

        // 获取图片
        $temp = (new BookHelper())->getBookImages($temp);

        // 如果该书可以抓取，并且数据库中没有该书，则做入库操作
        $book = Book::where('unique_code', $temp['unique_code'])->first();
        if (empty($book)) {
            Book::insert($temp);
        }

        return true;
    }
}