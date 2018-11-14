<?php

namespace App\Console\Commands;

use App\Console\Commands\SpiderHelper\BookHelper;
use Illuminate\Console\Command;

class SpiderBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓书本和图片';

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
        return (new BookHelper())->run();
    }
}
