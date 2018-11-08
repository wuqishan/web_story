<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class IndexController extends  Controller
{
    public function index(Request $request, BookService $service)
    {
        $params['title'] = $request->get('keyword', null);
        $params['sort'] = ['view', 'desc'];
        $results['book_popular'] = $service->get($params);

        $params['sort'] = ['last_update', 'desc'];
        $results['book_update'] = $service->get($params);

        return view('home.index.index',  ['results' => $results]);
    }
}
