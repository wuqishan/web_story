<?php

namespace App\Console\Commands;

use App\Helper\CurlMultiHelper;
use App\Models\Book;
use Ares333\Curl\Toolkit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderUpdateChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-chapter {category_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取书本对应的小说章节';

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
        $category_id = (int) $this->argument('category_id');
        if ($category_id > 0 && $category_id < 8) {
            $books = Book::where('category_id', $category_id)->select(['id', 'unique_code', 'category_id', 'newest_chapter', 'url'])->get()->toArray();
        } else {
            $books = Book::all(['id', 'unique_code', 'category_id', 'newest_chapter', 'url'])->toArray();
        }

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
            list($book_id, $book_unique_code, $category_id, $newest_chapter) = explode('-', $book_info);

            $chapter_sub_info = (array) $ql->find('#list dl dd')->map(function ($item) use ($tookit, $r) {
                $temp['url'] = $tookit->uri2url($item->find('a')->attr('href'), $r['info']['url']);
                $temp['title'] = trim($item->find('a')->text());
                return $temp;
            });
            $chapter_sub_info = array_pop($chapter_sub_info);     // 去除一层数组
            $length = count($chapter_sub_info);                         // 获取长度
            $run_at = false;                                            // 辅助判断从哪里开始是新增的章节
            foreach ($chapter_sub_info as $key => $val) {

                $temp['book_unique_code'] = $book_unique_code;
                // 作者 + 书名 + 章节名 + 排序key
                $temp['unique_code'] = md5($book_author . $book_title . $val['title'] . $key);
                $temp['title'] = $val['title'];
                $temp['view'] = 0;
                $temp['url'] = $val['url'];
                $temp['orderby'] = $key;
                $temp['category_id'] = $category_id;
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

                    // 跳过前面已经有的章节
                    if (! empty($newest_chapter)) {
                        if (! $run_at) {
                            if ($newest_chapter == $temp['unique_code']) {
                                $this->updateNextUniqueCode($temp);
                                $run_at = true;
                            }
                            continue;
                        }
                    }

                    // 插入章节
                    DB::table('chapter_' . $temp['category_id'])->insert($temp);
                    echo "新增章节: category_id: {$category_id}, 进度：{$book_number} / {$book_current}, title: {$temp['title']}, Url: {$temp['url']}\n";

                    // 更新book最新更新的章节
                    if ($key === $length - 1) {
                        Book::where('id', $book_id)->update(['newest_chapter' => $temp['unique_code']]);
                    }
                } catch (\Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), ", Url: {$r['info']['url']} \n";
                    $error = ['temp' => $temp, 'key' => $val, 'info' => $e->getMessage()];
                    $logs_file = storage_path('logs') . '/spider-chapter-' . date('Y-m-d') . '.txt';
                    @file_put_contents($logs_file, print_r($error, 1) . "\n\n\n");
                    exit;
                }
            }
        });

        return null;
    }

    public function updateNextUniqueCode($chapter)
    {
        if (! empty($chapter['next_unique_code'])) {
            DB::table('chapter_' . $chapter['category_id'])
                ->where('unique_code', $chapter['prev_unique_code'])
                ->update(['next_unique_code' => $chapter['unique_code']]);
        }
    }
}
