<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\CheckBookInfo;
use Illuminate\Console\Command;

class CheckChapterList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-chapter-list {category_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测章节list连表是否正确';

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
        $category_id = $this->argument('category_id');
        if (! empty($category_id)) {
            $books = Book::orderBy("id", "asc")
                ->where('category_id', $category_id)
                ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url', 'category_id'])
                ->get()
                ->toArray();
        } else {
            $books = Book::orderBy("id", "asc")
                ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url', 'category_id'])
                ->get()
                ->toArray();
        }

        $errors = [];
        $booksNumber = count($books);
        $chapterModel = new Chapter();
        foreach ($books as $key => $book) {
            // category_id 异常
            if ($book['category_id'] < 1 || $book['category_id'] > 7) {
                echo "书本分类异常不在 1 - 7范围\n";
                $errors[] = [
                    'msg' => '书本分类异常不在 1 - 7范围',
                    'data' => $book
                ];
                continue;
            }

            $chapter = $chapterModel->setTable($book['category_id'])->where('book_unique_code', $book['unique_code'])
                ->orderBy('orderby', 'asc')
                ->select(['id', 'title', 'unique_code', 'prev_unique_code', 'next_unique_code', 'orderby'])
                ->get()
                ->toArray();
            $count = count($chapter);
            for ($i = 0; $i < $count; $i++) {
                $error = ['data' => [], 'msg' => ''];

                // 排序异常
                if ($i != $chapter[$i]['orderby']) {
                    echo "排序数据异常\n";
                    $error['msg'] = "排序数据异常";
                    $error['data'] = $book;
                    $errors[] = $error;
                    break;
                }
                if ($i > 0 && $i < $count - 1) {

                    // 链表异常
                    if (
                        $chapter[$i - 1]['next_unique_code'] != $chapter[$i]['unique_code'] ||
                        $chapter[$i - 1]['unique_code'] != $chapter[$i]['prev_unique_code'] ||
                        $chapter[$i]['unique_code'] != $chapter[$i + 1]['prev_unique_code'] ||
                        $chapter[$i]['next_unique_code'] != $chapter[$i + 1]['unique_code']
                    ) {
                        echo "连表异常\n";
                        $error['msg'] = "章节链表异常";
                        $error['data'] = $book;
                        $errors[] = $error;
                        break;
                    }
                }

                // 最新文章异常
                if ($i == $count - 1) {
                    if ($chapter[$i]['unique_code'] != $book['newest_chapter']) {
                        $error['msg'] = "最新文章异常\n";
                        $error['data'] = $book;
                        $errors[] = $error;
                        break;
                    }
                }
                echo "Book 监测进度： {$booksNumber} / " . ($key + 1) . "，章节: {$chapter[$i]['orderby']}，暂无异常！！！ \n";
            }
        }

        if (! empty($errors)) {
            foreach ($errors as $v) {
                $checkBook = CheckBookInfo::where('book_id', $v['data']['id'])
                    ->where('status', 0)
                    ->first();
                if (empty($checkBook)) {
                    CheckBookInfo::insert([
                        'book_title' => $v['data']['title'],
                        'book_id' => $v['data']['id'],
                        'book_category_id' => $v['data']['category_id'],
                        'book_url' => $v['data']['url'],
                        'book_unique_code' => $v['data']['unique_code'],
                        'newest_chapter' => $v['data']['newest_chapter'],
                        'message' => $v['msg'],
                        'status' => 0,
                        'method' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            echo "问题书本有 " . count($errors) . " 条，已插入待处理表\n";
        }
    }
}
