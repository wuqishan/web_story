<?php

namespace App\Console\Commands;

use App\Console\Commands\SpiderHelper\ChapterUpdateHelper;
use App\Console\Commands\SpiderHelper\ContentUpdateHelper;
use App\Console\Commands\SpiderHelper\ImportUpdateHelper;
use App\Console\Commands\SpiderHelper\LoggerHelper;
use Illuminate\Console\Command;

class SpiderUpdateStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
                            第一步: 抓取更新的章节
                            第二步: 抓取更新章节的内容
                            第三步: 导入更新的章节
                            第四步: 记录导入的日志";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        @ini_set('memory_limit', '256M');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "======================= 第一步、抓取书本新章节 ======================\n";
        (new ChapterUpdateHelper())->run();

        echo "======================= 第二步、抓取书本章节的内容 ======================\n";
        (new ContentUpdateHelper())->run();


        echo "======================= 第三步、导入新增的章节 ======================\n";
        (new ImportUpdateHelper())->run();
        echo "======================= 第四步、记录日志 =====================\n";
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
        LoggerHelper::spiderChapter($import_log);
        echo "本次抓取结束!!!\n\n";
    }
}
