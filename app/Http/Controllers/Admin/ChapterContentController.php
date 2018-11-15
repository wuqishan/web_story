<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterContentService;
use App\Services\ChapterService;
use Illuminate\Http\Request;

class ChapterContentController extends Controller
{
    // 章节
    public function detail(Request $request, ChapterService $service, BookService $bookService)
    {
        $content_id = $request->content_id;
        $category_id = $request->category_id;
        if (intval($content_id) != $content_id) {
            $key = 'id';
        } else {
            $key = 'unique_code';
        }
        $results['chapter'] = $service->getOne(['category_id' => $category_id, $key => $content_id], true);
        $results['chapter']['content'] = $service->highlightEndKeyword($results['chapter']['content']);

        return view('admin.chapter_content.detail', ['results' => $results]);
    }

    public function updateContent(Request $request, ChapterContentService $service, ChapterService $chapterService)
    {
        $results = ['status' => true];
        $chapter_id = $request->get('chapter_id');
        $category_id = $request->get('category_id');
        $url = $request->get('url');

        list($content, $number_of_words) = $service->getContentFromUrl($url);
        $service->updateContent($chapter_id, $category_id, $content);
        $chapterService->updateNumberOfWords($chapter_id, $category_id, $number_of_words);

        return $results;
    }
}
