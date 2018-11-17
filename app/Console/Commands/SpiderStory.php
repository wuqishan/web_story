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
    protected $signature = 'command:new-story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
    第一步: 抓书本和图片\n
    第二步: 抓章节\n
    第三步: 抓章节内容\n
    第四步: 校验抓取的书本\n
    第五步: 导入正确的书本\n
    第六步: 记录日志";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        @ini_set('memory_limit', '512M');
        parent::__construct();
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
        (new ImportHelper())->run();
        echo "======================= 第六步、记录日志 =====================\n";
        $this->recordLog();

        return null;
    }

    /**
     * 记录本次抓取的日志信息
     */
    public function recordLog()
    {
        // 初始化模板
        $import_log = [
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        LoggerHelper::spiderBook($import_log);
        echo "本次抓取结束!!!\n\n";
    }
}
