<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\CheckBookInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测目前书本的完整性';

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
     * 本书结束的关键字
     *
     * @var array
     */
    public $finished_flag = [
        'end',
        '本书完',
        '全书完',
        '大结局',
        '完本'
    ];

    /**
     * @var array
     */
    public $errors = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $books = Book::where('finished', 0)
            ->orderBy("id", "asc")
            ->select(['id', 'title', 'url', 'unique_code', 'newest_chapter', 'category_id'])
            ->get()
            ->toArray();
        $books_number = count($books);

        foreach ($books as $key => $book) {
            // category_id 异常
            if ($book['category_id'] < 1 || $book['category_id'] > 7) {
                $this->logErrorBook($book, -1, 1);
                continue;
            }

            $chapter = DB::table('chapter_' . $book['category_id'])
                ->where('book_unique_code', $book['unique_code'])
                ->orderBy('orderby', 'asc')
                ->select(['id', 'unique_code', 'prev_unique_code', 'next_unique_code', 'orderby', 'number_of_words'])
                ->get()
                ->toArray();
            $chapter = array_map(function($v){ return (array) $v; }, $chapter);

            $count = count($chapter);
            if ($count == 0) {
                $this->logErrorBook($book, -1, 2);
                continue;
            }
            for ($i = 0; $i < $count; $i++) {
                // 排序异常
                if ($i != $chapter[$i]['orderby']) {
                    $this->logErrorBook($book, $i, 3);
                    break;
                }
                if ($i > 0 && $i < $count - 1) {
                    // 链表异常
                    if (
                        $chapter[$i - 1]['unique_code'] != $chapter[$i]['prev_unique_code'] ||
                        $chapter[$i]['next_unique_code'] != $chapter[$i + 1]['unique_code']
                    ) {
                        $this->logErrorBook($book, $i, 4);
                        break;
                    }
                }

                $content = DB::table('chapter_content_' . $book['category_id'])
                    ->where('id', $chapter[$i]['id'])
                    ->first();
                if (empty($content->content)) {
                    $this->logErrorBook($book, $i, 5);
                    break;
                }

                // 最新文章异常，循环最后一次执行该分支代码
                if ($i == $count - 1) {
                    if ($chapter[$i]['unique_code'] != $book['newest_chapter']) {
                        $this->logErrorBook($book, $i, 6);
                    } else if ($chapter[$i]['number_of_words'] > 0) {
                        if ($this->checkFinished($content->content)) {
                            $this->logErrorBook($book, $i, 7);
                        }
                    }
                }
            }
            echo "书本检测进度： {$books_number} / " . ($key + 1) . " \n";
        }

        if (count($this->errors) > 0) {
            $this->logInsertToDb();
        } else {
            echo "\n本次检测无异常书本\n";
        }
        echo "\n检测结束!!! \n";

        return null;
    }

    /**
     * @param $book
     * @param $orderby
     * @param $message_id
     *       '1' => 'CategoryID分类异常',
     *       '2' => '书本无章节信息',
     *       '3' => '书本抓取章节排序异常',
     *       '4' => '书本章节连表异常',
     *       '5' => '书本章节内容记录不存在',
     *       '6' => '书本最新章节错误异常',
     *       '7' => '书本可能已经完本',
     *
     * @return array
     */
    public function logErrorBook($book, $orderby, $message_id)
    {
        $error['message'] = CheckBookInfo::$messageIdMap[$message_id];
        $error['message_id'] = $message_id;
        $error['data'] = $book;
        $error['orderby'] = $orderby;
        $this->errors[] = $error;

        return $this->errors;
    }

    /**
     * 错误信息插入数据库
     */
    public function logInsertToDb()
    {
        if (!empty($this->errors)) {
            $need_insert = 0;
            $message = [];
            foreach ($this->errors as $v) {
                $checkBook = CheckBookInfo::where('book_id', $v['data']['id'])
                    ->whereIn('status', [1, 2, 3])
                    ->where('newest_chapter', $v['data']['newest_chapter'])
                    ->where('message_id', $v['message_id'])
                    ->first();
                if (empty($checkBook)) {
                    $insert = [
                        'book_title' => $v['data']['title'],
                        'book_id' => $v['data']['id'],
                        'book_category_id' => $v['data']['category_id'],
                        'book_url' => $v['data']['url'],
                        'book_unique_code' => $v['data']['unique_code'],
                        'newest_chapter' => $v['data']['newest_chapter'],
                        'chapter_orderby' => $v['orderby'],
                        'message' => $v['message'],
                        'message_id' => $v['message_id'],
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
//                    print_r($insert);
                    CheckBookInfo::insert($insert);
                    $need_insert++;
                    $message[] = $v['message'];
                }
            }
            echo "可能有问题的书本有 " . count($this->errors) . " 条, 需要插入的书本为 {$need_insert} 条\n";
            if (count($message) > 0) {
                echo "分别为：\n" . implode("\n", array_unique($message)) . "\n";
            }
        }
    }

    /**
     * 模糊检测本书是否完结
     *
     * @param $content
     * @return bool
     */
    public function checkFinished($content)
    {
        $results = false;
        if (!empty($content)) {
            if (preg_match('/' . implode('|', $this->finished_flag) . '/isuU', $content)) {
                $results = true;
            }
        }

        return $results;
    }
}
