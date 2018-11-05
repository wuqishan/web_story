<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class IndexController extends  Controller
{
    public function index(Request $request, BookService $service)
    {
        $results['book_popular'] = $service->get(['sort' => ['view', 'desc']]);
        $results['book_update'] = $service->get(['sort' => ['last_update', 'desc']]);

        return view('home.index.index',  ['results' => $results]);
    }

//    public function article(Request $request)
//    {
//        $category = $request->category_id;
//
//        return view('home.index.article');
//    }
}
