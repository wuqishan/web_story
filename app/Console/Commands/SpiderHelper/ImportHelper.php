<?php

namespace App\Console\Commands\SpiderHelper;

use App\Models\Book;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Support\Facades\DB;

class ImportHelper
{
    public function run()
    {
        $books = NewBook::all()->toArray();
        if (! empty($books)) {
            $book_number = count($books);
            foreach ($books as $key => $book) {
                $chapters = NewChapter::where('book_unique_code', $book['unique_code'])->get()->toArray();
                DB::beginTransaction();
                $insert_ids = [];
                foreach ($chapters as $chapter) {
                    $content = NewChapterContent::find($chapter['id'])->toArray();

                    // 插入章节
                    unset($chapter['id']);
                    $new_id = DB::table('chapter_' . $chapter['category_id'])->insertGetId($chapter);
                    $insert_ids[] = (int) $new_id;

                    // 插入内容
                    unset($content['id']);
                    $content['id'] = $new_id;
                    $insert_ids[] = (int) DB::table('chapter_content_' . $chapter['category_id'])->insertGetId($content);
                }

                // 插入书本
                unset($book['id']);
                $insert_ids[] = (int) Book::insertGetId($book);
                if (min($insert_ids) === 0) {
                    DB::rollBack();
                    echo "书本导入进度：{$book_number} / " . ($key + 1) . ",插入失败,已经回滚 \n";
                } else {
                    echo "书本导入进度：{$book_number} / " . ($key + 1) . ", 导入成功 \n";
                    DB::commit();
                }
            }
            // 清空临时表
            NewBook::truncate();
            NewChapter::truncate();
            NewChapterContent::truncate();
        }

        return null;
    }
}
