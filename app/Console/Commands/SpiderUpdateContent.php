<?php

namespace App\Console\Commands;

use App\Helper\CurlMultiHelper;
use App\Helper\ToolsHelper;
use App\Models\Book;
use Ares333\Curl\Toolkit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderUpdateContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-content {category_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取书本对应的内容';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $all_category_id = [1, 2, 3, 4, 5, 6, 7];
        $param = (int) $this->argument('category_id');
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
                        if (empty($content)) {
                            // 插入content数据表
                            $temp['id'] = $chapter_id;
                            $temp['content'] = $ql->find('#content')->html();
                            $temp['content'] = '<div id="content">' . $temp['content'] . '</div>';
                            DB::table('chapter_content_' . $category_id)->insert($temp);
                            // 更新chapter数据表的字数字段
                            $number_of_words = ToolsHelper::calcWords($temp['content']);
                            DB::table('chapter_' . $category_id)->where('id', $chapter_id)->update(['number_of_words' => $number_of_words]);

                            echo "更新章节内容: category_id: {$category_id}, 进度：{$update_chapters_length} / {$update_chapters_current} \n";
                        } else {
                            echo "章节内容已存在: category_id: {$category_id}, 进度：{$update_chapters_length} / {$update_chapters_current} \n";

                        }
                    } catch (\Exception $e) {
                        print_r([
                            'chapter_id' => $chapter_id,
                            'category_id' => $category_id
                        ]);
                        echo 'Caught exception: ',  $e->getMessage(), ", Url: {$r['info']['url']} \n";
                    }
                });
            }
        }


        return null;
    }
}
