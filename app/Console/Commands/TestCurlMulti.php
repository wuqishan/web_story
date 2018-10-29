<?php

namespace App\Console\Commands;

use App\Helper\CurlMultiHelper;
use Illuminate\Console\Command;
use Ares333\Curl\Toolkit;


class TestCurlMulti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-curl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试';

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
        $category_id_map = [
            'https://www.xbiquge6.com/xclass/1/1.html' => 1,
            'https://www.xbiquge6.com/xclass/2/1.html' => 2,
            'https://www.xbiquge6.com/xclass/3/1.html' => 3,
            'https://www.xbiquge6.com/xclass/4/1.html' => 4,
            'https://www.xbiquge6.com/xclass/5/1.html' => 5,
            'https://www.xbiquge6.com/xclass/6/1.html' => 6,
            'https://www.xbiquge6.com/xclass/7/1.html' => 7
        ];
        $start_urls = [
            'https://www.xbiquge6.com/xclass/1/1.html',
//            'https://www.xbiquge6.com/xclass/2/1.html',
//            'https://www.xbiquge6.com/xclass/3/1.html',
//            'https://www.xbiquge6.com/xclass/4/1.html',
//            'https://www.xbiquge6.com/xclass/5/1.html',
//            'https://www.xbiquge6.com/xclass/6/1.html',
//            'https://www.xbiquge6.com/xclass/7/1.html'
        ];
        $tookit = new Toolkit();
        /*
        $book_urls = CurlMultiHelper::get($start_urls, function ($ql, $curl, $r) use ($tookit) {
            $url1 = (array) $ql->find('#hotcontent .ll .item')->map(function ($item) use ($tookit, $r) {
                return $tookit->uri2url($item->find('.image a')->attr('href'), $r['info']['url']);
            })->flatten()->all();

            $url2 = (array) $ql->find('#newscontent .r li, #newscontent .l li')->map(function ($item) use ($tookit, $r) {
                return $tookit->uri2url($item->find('.s2 a')->attr('href'), $r['info']['url']);
            })->flatten()->all();

            return array_merge($url1, $url2);
        });
        */
/*
        foreach ($book_urls as $key => $url) {
            $category_id = $category_id_map[$key];
            $chapters = CurlMultiHelper::get($url, function ($ql, $curl, $r) use ($tookit, $category_id) {
                $temp['title'] = trim($ql->find('#info h1')->text());
                $temp['author'] = $ql->find('#info p:(0)')->text();
                $temp['author'] = preg_replace('/作(\s|(&nbsp;))*者(\:|：)/su', '', $temp['author']);
                $temp['author'] = trim($temp['author']);
                $temp['last_update'] = $ql->find('#info p:eq(2)')->text();
                $temp['last_update'] = preg_replace('/[\x{4e00}-\x{9fa5}]*：/suU', '', $temp['last_update']);
                $temp['description'] = $ql->find('#intro')->html();
                $temp['image_local_url'] = '';
                $temp['image_origin_url'] = $ql->find('#fmimg > img')->attr('src');
                $temp['url'] = $r['info']['url'];
                $temp['category_id'] = $category_id;
//                $temp['author_id'] = $this->getAuthorId($temp['author']);
                $temp['view'] = 0;
                $temp['newest_chapter'] = '';
                $temp['unique_code'] = md5($temp['author'] . $temp['title']);
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');

                return $temp;
            });
        }
*/

//        $book_urls = $book_urls['https://www.xbiquge6.com/xclass/1/1.html'];
//        print_r($book_urls);exit;

        $chapterUrls = ['https://www.xbiquge6.com/76_76449/'];
        $chapterUrlMapping = ['https://www.xbiquge6.com/76_76449/' => 1];

        $detail_urls = CurlMultiHelper::get($chapterUrls, function ($ql, $curl, $r) use ($tookit, $chapterUrlMapping) {
            $info = (array) $ql->find('#list dl dd')->map(function ($item) use ($tookit, $r, $chapterUrlMapping) {
                $temp['url'] = $tookit->uri2url($item->find('a')->attr('href'), $r['info']['url']);
                $temp['title'] = $item->find('a')->text();
                $temp['category_id'] = $chapterUrlMapping[$r['info']['url']];
                return $temp;
            });

            return $info;
        });

        print_r($detail_urls);exit;
    }
}
