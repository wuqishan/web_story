<?php

namespace App\Console\Commands;

use App\Helper\HttpHelper;
use App\Models\Book;
use Illuminate\Console\Command;

class SpiderBookImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-book-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '下载小说书本对应的图片';

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
        $save_dir = public_path('images/author/');
        $save_db_path = '/images/author/';
        if (! file_exists($save_dir)) {
            mkdir($save_dir, 0766, true);
        }
        $books = Book::all()->toArray();
        if (! empty($books)) {
            foreach ($books as $key => $book) {
                if (
                    ! empty($book['image_origin_url']) &&
                    (empty($book['image_local_url']) || ! file_exists(public_path($book['image_local_url'])))
                ) {
                    $ext = substr($book['image_origin_url'], strrpos($book['image_origin_url'], '.'));
                    if (empty($ext)) {
                        $ext = '.jpg';
                    }
                    $full_path = $save_dir . $book['unique_code'] . $ext;
                    $db_full_path = $save_db_path . $book['unique_code'] . $ext;
                    $content = HttpHelper::send($book['image_origin_url']);
                    if ($content) {
                        echo "共有 " . count($books) . " 本书，目前保存到：" . ($key + 1) . "\n";
                        @file_put_contents($full_path, $content);
                        Book::where('id', $book['id'])->update(['image_local_url' => $db_full_path]);
                    }
                }
            }
        }

    }
}
