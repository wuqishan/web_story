<?php

namespace App\Console\Commands;

use App\Console\Commands\SpiderHelper\ContentHelper;
use Illuminate\Console\Command;

class SpiderContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓章节内容';

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
        return (new ContentHelper())->run();
    }
}
