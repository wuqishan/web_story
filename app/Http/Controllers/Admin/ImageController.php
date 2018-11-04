<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // 图片
    public function index(BookService $service)
    {
        $results['book'] = $service->get();

        return view('admin.image.index', ['results' => $results]);
    }

    public function check(ImageService $service)
    {
        $results = $service->check();

        return $results;
    }

    public function update(ImageService $service)
    {
        $results = $service->update();

        return $results;
    }
}
