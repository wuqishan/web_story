<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class SpiderUpdateStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新已有的书本新章节';

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
        $books = Book::where('finished', 0)
            ->select(['newest_chapter', 'url', 'category_id'])
            ->get()
            ->toArray();
        $books = array_map(function ($v) {
            return (array) $v;
        }, $books);

    }
}
