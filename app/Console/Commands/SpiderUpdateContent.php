<?php

namespace App\Console\Commands;

use App\Console\Commands\Helper\ContentHelper;
use Illuminate\Console\Command;

class SpiderUpdateContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:content {category_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取书本对应的内容';

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
        $param = (int) $this->argument('category_id');

        return ContentHelper::run($param);
    }
}
