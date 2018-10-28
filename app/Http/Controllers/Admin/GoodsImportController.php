<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsImportController extends Controller
{
    public function index(Request $request)
    {
//        $results['data'] = $service->getList();

        return view('admin.goods_import.index');
    }

    public function create(Request $request)
    {
        return view('admin.goods_import.create');
    }
    public function store()
    {

    }
    public function edit()
    {

    }
    public function update()
    {

    }


}
