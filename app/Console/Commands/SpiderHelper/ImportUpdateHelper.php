<?php

namespace App\Console\Commands\SpiderHelper;

use App\Models\Book;
use App\Models\UpdateChapter;
use App\Models\UpdateChapterContent;
use Illuminate\Support\Facades\DB;

class ImportUpdateHelper
{
    public function run()
    {
        $update_chapters = UpdateChapter::orderBy('orderby', 'asc')->get();
        if (! empty($update_chapters)) {
            $update_chapters = $update_chapters->toArray();
        }
        $chapters = [];
        foreach ((array) $update_chapters as $v) {
            $chapters[$v['book_unique_code']][] = $v;
        }
        $book_number = count($chapters);

        if (! empty($chapters)) {
            $index = 0;
            foreach ($chapters as $key => $chapter) {

                DB::beginTransaction();
                $insert_ids = [];
                $add_words_number = 0;
                foreach ($chapter as $k => $c) {
                    $content = UpdateChapterContent::find($c['id']);
                    if (empty($content)) {
                        continue;
                    }
                    $content = $content->toArray();
                    // 最新更新日期存放在view中带过来
                    // 插入章节
                    if ($c <= strtotime('1970-01-01 00:00:00')) {
                        $c = time();
                    }
                    $last_update = date('Y-m-d H:i:s', $c['view']);
                    unset($c['id']);
                    $c['view'] = 0;
                    $new_id = DB::table('chapter_' . $c['category_id'])->insertGetId($c);
                    $insert_ids[] = (int) $new_id;

                    // 插入内容
                    unset($content['id']);
                    $content['id'] = $new_id;
                    $insert_ids[] = (int) DB::table('chapter_content_' . $c['category_id'])->insertGetId($content);

                    // 更新上一章节的下一章节唯一码
                    if ($k === 0 && ! empty($c['prev_unique_code'])) {
                        $insert_ids[] = DB::table('chapter_' . $c['category_id'])
                            ->where('unique_code', $c['prev_unique_code'])
                            ->update(['next_unique_code' => $c['unique_code']]);
                    }

                    // 新更新的章节总字数，用来更新书本的总字数
                    $add_words_number += $c['number_of_words'] > 0 ? $c['number_of_words'] : 0;

                    // 更新书本最新章节
                    if ($k === count($chapter) - 1) {
                        $insert_ids[] = Book::where('unique_code', $c['book_unique_code'])
                            ->update(
                                [
                                    'newest_chapter' => $c['unique_code'],
                                    'last_update' => $last_update,
                                    'number_of_words' => DB::raw('number_of_words + ' . $add_words_number)
                                ]
                            );
                    }
                }
                // 更新书本
                if (min($insert_ids) === 0) {
                    DB::rollBack();
                    echo "进度：{$book_number} / " . (++$index) . ",插入失败,已经回滚 \n";
                } else {
                    echo "进度：{$book_number} / " . (++$index) . ", 导入成功 \n";
                    DB::commit();
                }
            }

            // 清空临时表
            UpdateChapter::truncate();
            UpdateChapterContent::truncate();
        }

        return null;
    }
}
