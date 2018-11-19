<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // 图片
    public function index(BookService $service, ImageService $imageService)
    {
//        $results['book'] = $service->get();
        $results['check'] = $imageService->check();
//        dd($results);
        return view('admin.image.index', ['results' => $results]);
    }

    public function check(ImageService $service)
    {
        $results = $service->check();

        return $results;
    }

    public function update(Request $request, ImageService $service)
    {
        $book_id = $request->get('book_id', 0);
        $results = $service->update($book_id);

        return $results;
    }

    public function updateImageOriginUrl(Request $request, ImageService $service)
    {
        $results = ['status' => false];
        $book_id = $request->get('book_id', 0);
        $image_origin_url = $request->get('image_origin_url');

        $results['status'] = $service->updateImageOriginUrl($book_id, $image_origin_url);

        return $results;
    }
}
