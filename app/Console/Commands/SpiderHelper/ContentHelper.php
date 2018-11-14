<?php

namespace App\Console\Commands\Helper;

use App\Helper\CurlMultiHelper;
use App\Helper\ToolsHelper;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ContentHelper
{
    public function run()
    {
        $all_category_id = Category::all(['id'])->toArray();
        $all_category_id = array_column($all_category_id, 'id');

        foreach ($all_category_id as $category_id) {

            $data_model = DB::table('chapter_' . $category_id)
                ->where('number_of_words', 0)
                ->select(['id', 'category_id', 'url'])
                ->get();
            if (! empty($data_model)) {
                $chapters_init = $data_model->toArray();
            } else {
                continue;
            }

            $update_chapters_current = 0;
            $update_chapters_length = count($chapters_init);
            $chapters_init = array_chunk($chapters_init, 10000);    // 一次最多跑一万章节的内容
            
            foreach ($chapters_init as $chapters) {

                $update_chapters = [];
                if (! empty($chapters)) {
                    foreach ($chapters as $v) {
                        $update_chapters[$v->url] = "{$v->id}-{$v->category_id}";
                    }
                }

                if (! empty($update_chapters)) {
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
                            echo "进度: category_id: {$category_id}, 子进度: {$update_chapters_length} / {$update_chapters_current}  \n";
                        } catch (\Exception $e) {
                            // do somethings
                        }
                    });
                }
            }
        }

        return null;
    }
}
