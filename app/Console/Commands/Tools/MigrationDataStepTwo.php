<?php

namespace App\Console\Commands\Tools;

use App\Models\Book;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrationDataStepTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migration_two';

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
        $books = NewBook::all()->toArray();
        $books = array_map(function ($v) {
            return (array) $v;
        }, $books);

        $book_number = count($books);
        foreach ($books as $key => $book) {

            $chapters = NewChapter::where('book_unique_code', $book['unique_code'])->get()->toArray();
            $chapters = array_map(function ($v) {
                return (array) $v;
            }, $chapters);

            foreach ($chapters as $chapter) {
                $content = (array) NewChapterContent::where('id', $chapter['id'])->first();

                print_r($chapter);exit;

                unset($chapter['id']);
                $id = DB::table('chapter_' . $book['category_id'])->insertGetId($chapter);
                $content['id'] = $id;
                DB::table('chapter_content_' . $book['category_id'])->insert($content);
            }
            unset($books['id']);
            Book::insert($book);

            echo "进度：{$book_number} / {$key} \n";
        }

        echo "开始检测数量：\n";
        $chapter_number = 0;
        foreach ($books as $book) {
            $chapter_number += DB::table('chapter_' . $book['category_id'])
                ->where('book_unique_code', $book['unique_code'])
                ->count();

            echo "目前章节数量：{$chapter_number}\n";
        }

        for ($i = 1; $i <=7; $i++) {
            $chapter_number -= DB::table('chapter_' . $book['category_id'])->count();
            echo "目前章节数量：{$chapter_number}\n";
        }

        if ($chapter_number === 0) {
            echo "数量没问题 \n";
        }

        return null;
    }
}
