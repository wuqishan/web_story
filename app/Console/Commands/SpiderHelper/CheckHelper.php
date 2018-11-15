<?php

namespace App\Console\Commands\SpiderHelper;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\CheckBookInfo;
use Illuminate\Support\Facades\DB;

class CheckHelper
{
    // 本书结束的关键字
    public $finished_flag = [
        'end',
        '书完',
        '完本',
        '大结局',
        '完结'
    ];

    /**
     * @var array
     */
    public $errors = [];

    public $type = [
        '1' => '书本分类异常不在 1 - 7范围',
        '2' => '该书对应章节数量为空',
        '3' => '排序数据异常',
        '4' => '章节链表异常',
        '5' => '最新文章异常',
        '6' => '该本书籍可能已经完本'
    ];

    public function run()
    {
        // 已完本的则不做检测
        $books = Book::where('finished', 0)
            ->orderBy("id", "asc")
            ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url', 'category_id'])
            ->get()
            ->toArray();

        $booksNumber = count($books);
        foreach ($books as $key => $book) {
            // category_id 异常
            if ($book['category_id'] < 1 || $book['category_id'] > 7) {
                $this->logErrorBook($book, 1);
                continue;
            }

            $chapter = DB::table('chapter_' . $book['category_id'])->where('book_unique_code', $book['unique_code'])
                ->orderBy('orderby', 'asc')
                ->select(['id', 'unique_code', 'prev_unique_code', 'next_unique_code', 'orderby', 'number_of_words'])
                ->get()
                ->toArray();
            $count = count($chapter);
            if ($count == 0) {
                $this->logErrorBook($book, 2);
                continue;
            }

            for ($i = 0; $i < $count; $i++) {

                // 排序异常
                if ($i != $chapter[$i]['orderby']) {
                    $this->logErrorBook($book, 3);
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
                        $this->logErrorBook($book, 4);
                        break;
                    }
                }

                // 最新文章异常，循环最后一次执行该分支代码
                if ($i == $count - 1) {
                    if ($chapter[$i]['unique_code'] != $book['newest_chapter']) {
                        $this->logErrorBook($book, 5);
                    } else if ($chapter[$i]['number_of_words'] > 0) {
                        // 检测是否已经完本
                        $chapterContent = DB::table('chapter_content_' . $book['category_id'])
                            ->where('id', $chapter[$i]['id'])
                            ->select(['content'])
                            ->first();
                        if ($this->checkFinished($chapterContent->content)) {
                            $this->logErrorBook($book, 6);
                        }
                    }
                }
            }

            echo "进度： {$booksNumber} / " . ($key + 1) . "，暂无异常！！！ \n";
        }

        // 插入数据库
        $this->logInsertToDb();

        return null;
    }

    /**
     * @param $book
     * @param $type
     *      1: 书本分类异常不在 1 - 7范围
     *      2: 该书对应章节数量为空
     *      3: 排序数据异常
     *      4: 章节链表异常
     *      5: 最新文章异常
     *      6: 该本书籍可能已经完本
     *
     * @return array
     */
    public function logErrorBook($book, $type)
    {
        $error['msg'] = $this->type[$type];
        $error['data'] = $book;
        $this->errors[] = $error;
        echo "========================================================\n";
        echo "{$error['msg']}\n";
        echo "========================================================\n";

        return $this->errors;
    }

    /**
     * 错误信息插入数据库
     */
    public function logInsertToDb()
    {
        if (!empty($this->errors)) {
            $need_insert = 0;
            foreach ($this->errors as $v) {
                $checkBook = CheckBookInfo::where('book_id', $v['data']['id'])
                    ->where('status', 1)
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
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $need_insert++;
                }
            }
            echo "可能有问题的书本有 " . count($this->errors) . " 条, 需要插入的书本为 {$need_insert} 条，已插入待处理表\n";
        } else {
            echo "库中所有书本，暂无问题\n";
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
