<?php

namespace App\Console\Commands\UpdateBook;

use App\Console\Commands\SpiderHelper\ContentUpdateHelper;
use Illuminate\Console\Command;

class SpiderUpdateContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取更新章节的内容';

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
        return (new ContentUpdateHelper())->run();
    }
}
