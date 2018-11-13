<?php

namespace App\Console\Commands;

use App\Console\Commands\Helper\ChapterHelper;
use Illuminate\Console\Command;

class SpiderChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓章节';

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
        return (new ChapterHelper)->run();
    }

}
