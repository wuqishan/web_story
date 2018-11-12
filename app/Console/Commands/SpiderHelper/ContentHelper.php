<?php

namespace App\Console\Commands\Helper;

use App\Helper\CurlMultiHelper;
use App\Helper\ToolsHelper;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ContentHelper
{
    public static function run($param = 0)
    {
        $all_category_id = Category::all(['id'])->toArray();
        $all_category_id = array_column($all_category_id, 'id');

        if ($param > 0 && $param < 8) {
            $all_category_id = [$param];
        }

        foreach ($all_category_id as $category_id) {
            $chapters = DB::table('chapter_' . $category_id)
                ->where('number_of_words', 0)
                ->select(['id', 'category_id', 'url'])
                ->get();
            if (! empty($chapters)) {
                $chapters = $chapters->toArray();
            }

            $update_chapters = [];
            if (! empty($chapters)) {
                foreach ($chapters as $v) {
                    $update_chapters[$v->url] = "{$v->id}-{$v->category_id}";
                }
            }

            if (! empty($update_chapters)) {
                $update_chapters_current = 0;
                $update_chapters_length = count($update_chapters);
                CurlMultiHelper::get(array_keys($update_chapters), function ($ql, $curl, $r) use ($update_chapters, $update_chapters_length, &$update_chapters_current) {

                    $update_chapters_current++;
                    $chapter_info = $update_chapters[$r['info']['url']];
                    list($chapter_id, $category_id) = explode('-', $chapter_info);

                    try {
                        $content = DB::table('chapter_content_' . $category_id)->where('id', $chapter_id)->first();
                        // 插入content数据表
                        $temp['id'] = $chapter_id;
                        $temp['content'] = $ql->find('#content')->html();
                        $temp['content'] = '<div id="content">' . $temp['content'] . '</div>';
                        if (empty($content)) {
                            DB::table('chapter_content_' . $category_id)->insert($temp);
                        } else {
                            DB::table('chapter_content_' . $category_id)
                                ->where('id', $chapter_id)
                                ->update(['content' => $temp['content']]);
                        }

                        // 更新chapter数据表的字数字段
                        $number_of_words = ToolsHelper::calcWords($temp['content']);
                        $number_of_words = $number_of_words == 0 ? -1 : $number_of_words;
                        DB::table('chapter_' . $category_id)->where('id', $chapter_id)->update(['number_of_words' => $number_of_words]);
                        echo "更新章节内容: category_id: {$category_id}, 进度：{$update_chapters_length} / {$update_chapters_current} \n";
                    } catch (\Exception $e) {
//                        $error = [
//                            'chapter_id' => $chapter_id,
//                            'category_id' => $category_id,
//                            'url' => $r['info']['url']
//                        ];
//                        $logs_file = storage_path('logs') . '/spider-chapter-content-' . date('Y-m-d') . '.txt';
//                        @file_put_contents($logs_file, print_r($error, 1) . "\n\n\n");
                    }
                });
            }
        }

        return null;
    }
}
