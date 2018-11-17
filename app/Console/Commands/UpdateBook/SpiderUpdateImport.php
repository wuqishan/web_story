<?php

namespace App\Console\Commands\UpdateBook;

use App\Console\Commands\SpiderHelper\ImportHelper;
use App\Console\Commands\SpiderHelper\ImportUpdateHelper;
use App\Models\Book;
use App\Models\NewBook;
use App\Models\NewChapter;
use App\Models\NewChapterContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderUpdateImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新新章节的数据导入';

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
        return (new ImportUpdateHelper())->run();
    }
}
