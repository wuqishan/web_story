<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\CheckBookInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SpiderCalcWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calc-book-words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计并更新每本书的总字数';

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
     * @var array
     */
    public $errors = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $books = Book::orderBy("id", "asc")
            ->select(['id', 'unique_code', 'category_id'])
            ->get()
            ->toArray();
        $books_number = count($books);

        foreach ($books as $key => $book) {

            $chapter = DB::table('chapter_' . $book['category_id'])
                ->where('book_unique_code', $book['unique_code'])
                ->orderBy('orderby', 'asc')
                ->select(['id', 'number_of_words'])
                ->get()
                ->toArray();
            $chapter = array_map(function($v){ return (array) $v; }, $chapter);

            $book_number_of_words = 0;
            foreach ($chapter as $c) {
                $book_number_of_words += $c['number_of_words'] > 0 ? $c['number_of_words'] : 0;
            }
            Book::where('id', $book['id'])->update(['number_of_words' => $book_number_of_words]);

            echo "书本字数更新进度： {$books_number} / " . ($key + 1) . " \n";
        }

        return null;
    }
}
