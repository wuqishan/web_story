<?php

namespace App\Console\Commands\SpiderHelper;

use App\Helper\CurlMultiHelper;
use App\Helper\ToolsHelper;
use App\Models\NewChapter;
use App\Models\NewChapterContent;

class ContentHelper
{
    public function run()
    {
        $data_model = NewChapter::where('number_of_words', 0)
            ->select(['id', 'url'])
            ->get();
        if (! empty($data_model)) {
            $chapters_init = $data_model->toArray();
        } else {
            return null;
        }

        $update_chapters_current = 0;
        $update_chapters_length = count($chapters_init);
        $chapters_init = array_chunk($chapters_init, 10000);    // 一次最多跑一万章节的内容

        foreach ($chapters_init as $chapters) {

            $update_chapters = [];
            if (! empty($chapters)) {
                foreach ($chapters as $v) {
                    $update_chapters[$v['url']] = "{$v['id']}";
                }
            }

            if (! empty($update_chapters)) {
                CurlMultiHelper::get(array_keys($update_chapters), function ($ql, $curl, $r) use ($update_chapters, $update_chapters_length, &$update_chapters_current) {

                    $update_chapters_current++;
                    $chapter_id = $update_chapters[$r['info']['url']];
                    try {
                        // 插入content数据表
                        $temp['id'] = $chapter_id;
                        $temp['content'] = $ql->find('#content')->html();
                        $temp['content'] = '<div id="content">' . $temp['content'] . '</div>';
                        NewChapterContent::insert($temp);

                        // 更新chapter数据表的字数字段
                        $number_of_words = ToolsHelper::calcWords($temp['content']);
                        $number_of_words = $number_of_words == 0 ? -1 : $number_of_words;
                        NewChapter::where('id', $chapter_id)->update(['number_of_words' => $number_of_words]);
                        echo "进度: {$update_chapters_length} / {$update_chapters_current}  \n";
                    } catch (\Exception $e) {
                        // todo somethings
                    }
                });
            }
        }

        return null;
    }
}
