<?php

namespace App\Console\Commands;

use App\Console\Commands\SpiderHelper\BookHelper;
use App\Console\Commands\SpiderHelper\ChapterHelper;
use App\Console\Commands\SpiderHelper\CheckHelper;
use App\Console\Commands\SpiderHelper\ContentHelper;
use App\Console\Commands\SpiderHelper\LoggerHelper;
use App\Helper\CacheHelper;
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
        @ini_set('memory_limit', '256M');
        parent::__construct();

        // 建立缓存文件夹
        $step_dir = storage_path('step');
        if (!file_exists($step_dir)) {
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
        if (!in_array($step, [1, 2, 3, 4])) {
            $step = 1;
        }

        for ($i = $step; $i <= 4; $i++) {
            file_put_contents($step_file, $i);
            if ($i === 1) {
                echo "======================= 第一步、抓书本和图片 ======================\n";
                (new BookHelper())->run();
            } else if ($i === 2) {
                echo "======================= 第二步、抓章节信息 =====================\n";
                (new ChapterHelper())->run();
            } else if ($i === 3) {
                echo "======================= 第三步、抓章节内容 =====================\n";
                (new ContentHelper())->run();
            } else if ($i === 4) {
                echo "======================= 第四步、校验抓取的书本 =====================\n";
                (new CheckHelper())->run();
            }
        }

        // 记录日志
        $this->recordLog();

        // reset unique flag
        $this->delUniqueFlag();

        // 重置为1
        file_put_contents($step_file, '1');

        return null;
    }

    /**
     * 记录本次抓取的日志信息
     */
    public function recordLog()
    {
        // 初始化模板
        $import_log = [
            'flag' => $this->getUniqueFlag(),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // 记录日志
        echo "========================开始记录日志...=========================\n\n";
        LoggerHelper::spiderBook($import_log);
        LoggerHelper::spiderChapter($import_log);
        echo "========================记录日志结束=========================\n";
    }

    /**
     * 本次抓取的flag
     *
     * @return string
     */
    public function getUniqueFlag()
    {
        $key = 'unique_key';
        if (CacheHelper::has($key) && !empty(CacheHelper::get($key))) {
            $unique_flag = CacheHelper::get($key);
        } else {
            $unique_flag = md5(time() . rand(0, 1000));
        }

        return $unique_flag;
    }

    /**
     * 删除unique flag缓存
     *
     * @return mixed
     */
    public function delUniqueFlag()
    {
        $key = 'unique_key';

        return CacheHelper::delete($key);
    }
}
