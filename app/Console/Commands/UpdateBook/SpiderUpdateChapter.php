<?php

namespace App\Console\Commands\UpdateBook;

use App\Console\Commands\SpiderHelper\ChapterUpdateHelper;
use Illuminate\Console\Command;

class SpiderUpdateChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-chapter';

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
        return (new ChapterUpdateHelper())->run();
    }

}
