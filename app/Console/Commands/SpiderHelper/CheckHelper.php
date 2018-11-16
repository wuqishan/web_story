<?php

namespace App\Console\Commands\SpiderHelper;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\CheckBookInfo;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Support\Facades\DB;

class CheckHelper
{
    // 本书结束的关键字
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

    public function run()
    {
        do {
            echo "==================循环检测=================== \n";
            $continue_check = false;

            $books = NewBook::orderBy("id", "asc")
                ->select(['id', 'title', 'unique_code', 'newest_chapter', 'url', 'category_id'])
                ->get()
                ->toArray();
            $booksNumber = count($books);

            foreach ($books as $key => $book) {
                // category_id 异常
                if ($book['category_id'] < 1 || $book['category_id'] > 7) {
                    $this->delete($book);
                    $continue_check = true;
                    continue;
                }

                $chapter = NewChapter::where('book_unique_code', $book['unique_code'])
                    ->orderBy('orderby', 'asc')
                    ->select(['id', 'unique_code', 'prev_unique_code', 'next_unique_code', 'orderby', 'number_of_words'])
                    ->get()
                    ->toArray();

                $count = count($chapter);
                if ($count == 0) {
                    $this->delete($book);
                    $continue_check = true;
                    continue;
                }
                for ($i = 0; $i < $count; $i++) {
                    // 排序异常
                    if ($i != $chapter[$i]['orderby']) {
                        $this->delete($book);
                        $continue_check = true;
                        break;
                    }
                    if ($i > 0 && $i < $count - 1) {
                        // 链表异常
                        if (
                            $chapter[$i - 1]['unique_code'] != $chapter[$i]['prev_unique_code'] ||
                            $chapter[$i]['next_unique_code'] != $chapter[$i + 1]['unique_code']
                        ) {
                            $this->delete($book);
                            $continue_check = true;
                            break;
                        }
                    }

                    $content = NewChapterContent::find($chapter[$i]['id']);
                    if (empty($content->content)) {
                        $this->delete($book);
                        $continue_check = true;
                        break;
                    }
                    // 最新文章异常，循环最后一次执行该分支代码
                    if ($i == $count - 1) {
                        if ($chapter[$i]['unique_code'] != $book['newest_chapter']) {
                            $continue_check = true;
                            $this->delete($book);
                        }
                    }
                }
                echo "进度： {$booksNumber} / " . ($key + 1) . " \n";
            }
        } while ($continue_check || $booksNumber === 0);

        return null;
    }

    /**
     * 只要有问题，就全部删除
     *
     * @param $book
     */
    public function delete($book)
    {
        $chapter_id = NewChapter::where('book_unique_code', $book['unique_code'])
            ->select(['id'])
            ->get()
            ->toArray();
        if (! empty($chapter_id)) {
            $chapter_id = array_column($chapter_id, 'id');
        }
        NewChapterContent::destroy((array) $chapter_id);
        NewChapter::destroy((array) $chapter_id);
        NewBook::destroy($book['id']);
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
//    public function checkFinished($content)
//    {
//        $results = false;
//        if (!empty($content)) {
//            if (preg_match('/' . implode('|', $this->finished_flag) . '/isuU', $content)) {
//                $results = true;
//            }
//        }
//
//        return $results;
//    }
}
