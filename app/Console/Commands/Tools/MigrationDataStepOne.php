<?php

namespace App\Console\Commands\Tools;

use App\Models\Book;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrationDataStepOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migration_one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '数据迁移和清洗';

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
     * 循环所有的书籍
     *      取所有的章节和对应的content，并且数据无误则转存 new* 系列的数据表
     *
     * 结束后再清空所有的书籍、章节、内容
     *
     * 在取出 new* 系列的书籍分表存入原数据表中
     *
     * @return mixed
     */
    public function handle()
    {
        $books = Book::all()->toArray();

        $book_number = count($books);
        $error_book = 0;
        $right_book = 0;
        foreach ($books as $book_key => $book) {
            if (
                empty($book['newest_chapter']) ||
                empty($book['title']) ||
                empty($book['author']) ||
                empty($book['author_id']) ||
                empty($book['last_update']) ||
                empty($book['image_local_url']) ||
                empty($book['image_origin_url']) ||
                empty($book['url']) ||
                $book['category_id'] <=0 ||
                $book['url'] >=8
            ) {
                $error_book++;
                echo "进度: {$book_number} / {$book_key}, 正常/问题: {$right_book} / {$error_book} title: {$book['title']}\n";
                continue;
            }

            $chapters = DB::table('chapter_' . $book['category_id'])
                ->where('book_unique_code', $book['unique_code'])
                ->get();

            if (empty($chapters)) {
                continue;
            }
            $chapters = $chapters->toArray();
            $chapters = array_map(function ($v) {
                return (array) $v;
            }, $chapters);

            $content = null;
            $continue_flag = false;
            foreach ($chapters as $k => $chapter) {
                if (! $this->checkChapter($book,$chapters, $k)) {
                    $continue_flag = true;
                    break;
                }

                $content = DB::table('chapter_content_' . $book['category_id'])
                    ->where('id', $chapter['id'])
                    ->first();
                if (empty($content)) {
                    $continue_flag = true;
                    break;
                }
            }
            if ($continue_flag) {
                $error_book++;
                echo "进度: {$book_number} / {$book_key}, 正常/问题: {$right_book} / {$error_book} title: {$book['title']}\n";
                continue;
            }

            $right_book++;
            echo "进度: {$book_number} / {$book_key}, 正常/问题: {$right_book} / {$error_book} title: {$book['title']}\n";

            // 插入
            NewBook::insert($book);
            foreach ($chapters as $v) {
                $content = (array) DB::table('chapter_content_' . $v['category_id'])
                    ->where('id', $v['id'])
                    ->first();

                unset($v['id']);
                $id = NewChapter::insertGetId($v);
                $content['id'] = $id;
                NewChapterContent::insert($content);
            }
        }

        // 清空数据表
        Book::truncate();
        for ($i = 1; $i <= 7; $i++) {
            DB::table('chapter_' . $i)->truncate();
            DB::table('chapter_content_' . $i)->truncate();
        }

        return null;
    }


    public function checkChapter($book, & $chapters, $key)
    {
        if (
            $book['category_id'] != $chapters[$key]['category_id'] ||
            empty($chapters[$key]['title']) ||
            empty($chapters[$key]['url']) ||
            $chapters[$key]['number_of_words'] == 0 ||
            $chapters[$key]['orderby'] !== $key
        ) {
            return false;
        }

        if (count($chapters) === 1) {
            if (! empty($chapters[$key]['prev_unique_code']) || ! empty($chapters[$key]['next_unique_code'])) {
                return false;
            }
        } else {

            if ($key === 0) {
                if (! empty($chapters[$key]['prev_unique_code']) || empty($chapters[$key]['next_unique_code'])) {
                    return false;
                }
            } else if ($key === count($chapters) - 1) {
                if (
                    empty($chapters[$key]['prev_unique_code']) ||
                    ! empty($chapters[$key]['next_unique_code']) ||
                    $chapters[$key]['unique_code'] != $book['newest_chapter']
                )
                {
                    return false;
                }
            } else {
                if (
                    $chapters[$key - 1]['unique_code'] != $chapters[$key]['prev_unique_code'] ||
                    $chapters[$key]['next_unique_code'] != $chapters[$key + 1]['unique_code']
                ) {
                    return false;
                }
            }
        }

        return true;
    }
}
