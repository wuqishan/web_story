<?php

namespace App\Console\Commands;


use App\Console\Commands\Helper\BookHelper;
use Illuminate\Console\Command;

class SpiderUpdateBook extends Command
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
    protected $description = '抓取小说书本信息';

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
        return BookHelper::run();
    }
}
