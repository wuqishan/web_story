<?php

namespace App\Console\Commands;

use App\Console\Commands\Helper\BookHelper;
use App\Console\Commands\Helper\ChapterHelper;
use App\Console\Commands\Helper\ContentHelper;
use App\Models\ImportLog;
use Illuminate\Console\Command;

class SpiderStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:story {--step=?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '1: 抓书本和图片 => 2: 抓章节 => 3: 抓章节内容 => 4: 校验抓取的书本';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        @ini_set('memory_limit','256M');
        parent::__construct();

        // 建立缓存文件夹
        $step_dir = storage_path('step');
        if (! file_exists($step_dir)) {
            mkdir($step_dir, 0766, true);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // 如果传了指定从第几步开始抓，则直接开始第几步开始抓，否则从历史文件中读取从第几步开始抓
        $step = intval($this->option('step'));

        $step_file = storage_path('step/step.txt');
        if (! in_array($step, [1, 2, 3, 4])) {
            $step = 1;
        }

        $spider_info = [];
        for ($i = $step; $i <= 4; $i++) {
            file_put_contents($step_file, $i);
            if ($i === 1) {
                echo "======================= 第一步、抓书本和图片 ======================\n";
                $spider_info['book'] = (new BookHelper)->run();
            } else if ($i === 2) {
                echo "======================= 第二步、抓章节 =====================\n";
                $spider_info['chapter'] = (new ChapterHelper)->run();
            } else if ($i === 3) {
                echo "======================= 第三步、抓章节内容 =====================\n";
                (new ContentHelper)->run();
            } else if ($i === 4) {
                echo "======================= 第四步、校验抓取的书本 =====================\n";
                (new CheckHelper)->run();
            }
        }

        // 记录日志
        $this->recordLog($spider_info);

        // 重置为1
        file_put_contents($step_file, '1');

        return null;
    }

    public function recordLog($spider_info)
    {
        // 初始化模板
        $import_log = [
            'flag' => $this->getUniqueFlag(),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        // book 采集
        if (isset($spider_info['book'])) {
            $import_log['type'] = 1;
            $import_log['number'] = $spider_info['book']['number'];
            $import_log['content'] = json_encode($spider_info['book']['data']);
            ImportLog::insert($import_log);
        }

        // chapter 采集
        if (isset($spider_info['chapter'])) {
            $import_log['type'] = 2;
            $import_log['number'] = $spider_info['chapter']['number'];
            $import_log['content'] = json_encode($spider_info['chapter']['data']);
            ImportLog::insert($import_log);
        }
    }

    /**
     * 本次抓取的flag
     *
     * @return string
     */
    public function getUniqueFlag()
    {
        return md5(time() . rand(0, 1000));
    }
}
