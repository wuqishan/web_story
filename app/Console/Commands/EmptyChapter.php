<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\CheckBookInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EmptyChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:chapter-empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清空错误的章节数据';

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
        $exception = CheckBookInfo::where('status', 1)
            ->whereIn('method', [2, 3])
            ->get();
        if (! empty($exception)) {
            $exception = $exception->toArray();
            foreach ($exception as $v) {
                if ($v['method'] == 2) {
                    Book::where('id', $v['book_id'])->update(['newest_chapter' => '']);
                } else if ($v['method'] == 3) {
                    Book::where('id', $v['book_id'])->delete();
                }

                $ids = DB::table('chapter_' . $v['book_category_id'])
                    ->where('book_unique_code', $v['book_unique_code'])
                    ->select(['id'])
                    ->get()
                    ->toArray();
                $ids = array_column($ids, 'id');

                DB::table('chapter_' . $v['book_category_id'])
                    ->whereIn('id', $ids)
                    ->delete();

                DB::table('chapter_content_' . $v['book_category_id'])
                    ->whereIn('id', $ids)
                    ->delete();

                CheckBookInfo::where('id', $v['id'])->update(['status' => 2]);
            }

            echo "更新完成!\n";
        }

    }
}
