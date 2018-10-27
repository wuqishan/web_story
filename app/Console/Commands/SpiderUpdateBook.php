<?php

namespace App\Console\Commands;

use App\Services\Spider\UpdateBookService;
use Illuminate\Console\Command;

class SpiderUpdateBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-book';

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
        $book_urls = [
            1 => 'https://www.xbiquge6.com/xclass/1/1.html',
            2 => 'https://www.xbiquge6.com/xclass/2/1.html',
            3 => 'https://www.xbiquge6.com/xclass/3/1.html',
            4 => 'https://www.xbiquge6.com/xclass/4/1.html',
            5 => 'https://www.xbiquge6.com/xclass/5/1.html',
            6 => 'https://www.xbiquge6.com/xclass/6/1.html',
            7 => 'https://www.xbiquge6.com/xclass/7/1.html'
        ] ;

        foreach ($book_urls as $key => $url) {
            $updateBookService = new UpdateBookService();
            $updateBookService->getBook($key, $url);
        }
    }
}
