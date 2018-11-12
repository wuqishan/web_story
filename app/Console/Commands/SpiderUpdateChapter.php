<?php

namespace App\Console\Commands;

use App\Console\Commands\Helper\ChapterHelper;
use Illuminate\Console\Command;

class SpiderUpdateChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:chapter {category_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取书本对应的小说章节';

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
        $category_id = (int) $this->argument('category_id');
        return ChapterHelper::run($category_id);
    }

}
