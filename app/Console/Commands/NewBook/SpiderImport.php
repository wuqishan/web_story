<?php

namespace App\Console\Commands\NewBook;

use App\Console\Commands\SpiderHelper\ImportHelper;
use App\Models\Book;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:new-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '把抓取到新书本，导入到线上访问的数据表';

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
        return (new ImportHelper())->run();
    }
}
