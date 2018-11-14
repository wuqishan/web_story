<?php

namespace App\Console\Commands\SpiderHelper;


use App\Models\Book;
use App\Models\Category;
use App\Models\ImportLog;
use Illuminate\Support\Facades\DB;

class LoggerHelper
{
    /**
     * 记录书本导入日志
     *
     * @param $import_log
     */
    public static function spiderBook($import_log)
    {
        $book = [];
        $number = 0;
        $content = [];
        $bookModel = Book::where('is_new', 1)->select(['id'])->get();
        if (! empty($bookModel)) {
            $book = $bookModel->toArray();
        }
        if (! empty($book)) {
            $book_id = array_column($book, 'id');
            $number = count($book_id);
            $content = $book_id;
        }
        $import_log['type'] = 1;

        if ($number > 0 && ! empty($content)) {
            $import_log['number'] = $number;
            $import_log['content'] = json_encode($content);
            ImportLog::insert($import_log);
            Book::where('is_new', 1)->update(['is_new' => 2]);
        }
    }

    /**
     * 记录章节导入日志
     *
     * @param $import_log
     */
    public static function spiderChapter($import_log)
    {
        $category = Category::getAll();
        $category_id = array_column($category, 'id');
        $number = 0;
        $content = [];
        foreach ($category_id as $v) {
            $chapter = [];
            $chapterModel = DB::table('chapter_' . $v)->select(['id'])->get();
            if (! empty($chapterModel)) {
                $chapter = $chapterModel->toArray();
            }
            if (! empty($chapter)) {
                $chapter_id = array_column($chapter, 'id');
                $number += count($chapter_id);
                $content[$v] = $chapter_id;
            }

            DB::table('chapter_' . $v)
                ->where('is_new', '=', 1)
                ->update(['is_new' => 2]);
        }

        $import_log['type'] = 2;
        if ($number > 0 && ! empty($content)) {
            $import_log['number'] = $number;
            $import_log['content'] = json_encode($content);
            ImportLog::insert($import_log);
        }
    }
}
