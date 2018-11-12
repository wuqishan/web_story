<?php

namespace App\Console\Commands;

use App\Console\Commands\Helper\BookHelper;
use App\Console\Commands\Helper\ChapterHelper;
use App\Console\Commands\Helper\ContentHelper;
use Illuminate\Console\Command;

class SpiderStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓书本和图片 => 抓章节 => 抓章节内容';

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
        $step_dir = storage_path('step');
        if (! file_exists($step_dir)) {
            mkdir($step_dir, 0766, true);
        }
        $step_file = storage_path('step/step.txt');
        if (! file_exists($step_file)) {
            file_put_contents($step_file, '0');
        }
        $step = intval(file_get_contents($step_file));

        for ($i = $step; $i < 3; $i++) {
            if ($i === 0) {
                echo "========================================= 第一步 ==========================================\n";
                echo "========================================= 第一步 ==========================================\n";
                echo "========================================= 第一步 ==========================================\n";
                $this->spiderBook();
            } else if ($i === 1) {
                echo "========================================= 第二步 ==========================================\n";
                echo "========================================= 第二步 ==========================================\n";
                echo "========================================= 第二步 ==========================================\n";
                $this->spiderChapter();
            } else if ($i === 2) {
                echo "========================================= 第三步 ==========================================\n";
                echo "========================================= 第三步 ==========================================\n";
                echo "========================================= 第三步 ==========================================\n";
                $this->spiderContent();
            }
        }

        // 重置为0
        file_put_contents($step_file, '0');

        return null;
    }

    public function spiderContent()
    {
        ContentHelper::run();
    }

    public function spiderChapter()
    {
        ChapterHelper::run();
    }

    public function spiderBook()
    {
        BookHelper::run();
    }
}
