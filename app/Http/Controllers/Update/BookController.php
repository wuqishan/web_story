<?php
namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Services\CheckBookInfoService;
use Illuminate\Http\Request;

class BookController extends  Controller
{
    public function index(Request $request, CheckBookInfoService $service)
    {
        $params['status'] = 0;
        $sort = ['id', 'desc'];
        $results['data'] = $service->get($params, $sort);

        return view('update.book.index', ['results' => $results]);
    }

}
