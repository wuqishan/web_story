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
    protected $signature = 'command:check-chapter-list {book_id?}';

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
        $bookId = $this->argument('book_id');
        if (! empty($bookId)) {
            $books = Book::orderBy("id", "asc")
                ->where('id', $bookId)
                ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url'])
                ->get()
                ->toArray();
        } else {
            $books = Book::orderBy("id", "asc")
                ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url'])
                ->get()
                ->toArray();
        }


        $errors = [];
        $booksNumber = count($books);
        foreach ($books as $key => $book) {
            $chapter = Chapter::where('book_unique_code', $book['unique_code'])
                ->orderBy('orderby', 'asc')
                ->select(['id', 'title', 'unique_code', 'prev_unique_code', 'next_unique_code', 'orderby'])
                ->get()
                ->toArray();
            $count = count($chapter);
            for ($i = 0; $i < $count; $i++) {
                $error = ['data' => [], 'msg' => ''];
                if ($i != $chapter[$i]['orderby']) {
                    echo "排序数据异常\n";
                    $error['msg'] = "排序数据异常";
                    $error['data'] = $book;
                    $errors[] = $error;
                    break;
                }
                if ($i > 0 && $i < $count - 1) {
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
                if ($i == $count - 1) {
                    if ($chapter[$i]['unique_code'] != $book['newest_chapter']) {
                        $error['msg'] = "最新文章异常\n";
                        $error['data'] = $book;
                        $errors[] = $error;
                        break;
                    }
                }
            }
            echo "Book 总数 {$booksNumber}, 当前检测到：" . ($key + 1) ."  !!!\n";
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
