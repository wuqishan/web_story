<?php

namespace App\Console\Commands\NewBook;

use App\Console\Commands\SpiderHelper\CheckHelper;
use Illuminate\Console\Command;

class SpiderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:new-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '校验抓取的书本';

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
        return (new CheckHelper())->run();
    }
}
