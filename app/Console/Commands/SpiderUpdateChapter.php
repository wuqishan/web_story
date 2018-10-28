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
    protected $signature = 'command:spider-chapter {category_id?}';

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
        $category_id = (int) $this->argument('category_id');
        if ($category_id > 0) {
            $books = Book::where('category_id', $category_id)->get()->toArray();
        } else {
            $books = Book::all()->toArray();
        }

        $updateChapterService = new UpdateChapterService();
        foreach ($books as $book) {
            if (intval($book['category_id']) >= 1 && intval($book['category_id']) <= 7) {
                $updateChapterService->getChapter($book['url'], $book['newest_chapter'], $book['category_id']);
            }
        }
    }
}
