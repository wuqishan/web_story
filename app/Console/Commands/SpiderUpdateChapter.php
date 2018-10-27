<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\CheckBookInfo;
use App\Services\Spider\UpdateChapterService;
use Illuminate\Console\Command;

class SpiderUpdateChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-chapter {book_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取书本对应的小说章节';

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
        $books = Book::all()->toArray();

        $updateChapterService = new UpdateChapterService();
        foreach ($books as $book) {
            $updateChapterService->getChapter($book['url'], $book['newest_chapter']);
        }
    }
}
