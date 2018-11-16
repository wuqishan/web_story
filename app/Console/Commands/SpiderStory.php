<?php

namespace App\Console\Commands;

use App\Console\Commands\SpiderHelper\BookHelper;
use App\Console\Commands\SpiderHelper\ChapterHelper;
use App\Console\Commands\SpiderHelper\CheckHelper;
use App\Console\Commands\SpiderHelper\ContentHelper;
use App\Console\Commands\SpiderHelper\ImportHelper;
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
    protected $signature = 'command:story {--step=?} {--log=?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '1: 抓书本和图片 => 2: 抓章节 => 3: 抓章节内容 => 4: 校验抓取的书本 => 5: 导入正确的书本';

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

        echo "======================= 第一步、抓书本和图片 ======================\n";
        (new BookHelper())->run();
        echo "======================= 第二步、抓章节信息 =====================\n";
        (new ChapterHelper())->run();
        echo "======================= 第三步、抓章节内容 =====================\n";
        (new ContentHelper())->run();
        echo "======================= 第四步、校验抓取的书本 =====================\n";
        (new CheckHelper())->run();
        echo "======================= 第五步、导入正确的书本 =====================\n";
//        (new ImportHelper())->run();
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

        // 暂无必要记录章节的log
        // LoggerHelper::spiderChapter($import_log);
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
