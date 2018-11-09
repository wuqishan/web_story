<?php

namespace App\Console\Commands;

use App\Helper\HttpHelper;
use App\Helper\ToolsHelper;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterContent;
use Illuminate\Console\Command;

class CalcChapterWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calc-words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一次性使用---计算章节多少字数';

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
        $categories = [1, 2,3,4,5,6,7];
        foreach ($categories as $c) {
            $chapterModel = new Chapter();
            $chapterModel = $chapterModel->setTable($c);
            $chapter = $chapterModel->where('category_id', $c)->select(['id'])->get()->toArray();



            $chapterContentModel = new ChapterContent();
            $chapterContentModel = $chapterContentModel->setTable($c);
            if (! empty($chapter)) {
                foreach ($chapter as $k => $ch) {
                    $content = $chapterContentModel->where('id', $ch['id'])->first();
                    $number = ToolsHelper::calcWords($content->content);
                    $chapterModel->where('id', $ch['id'])->update(['number_of_words' => $number]);
                    echo "当前category_id = {$c} , " . count($chapter) . "---" . ($k + 1) . "\n";
                }
            }
        }

    }
}
