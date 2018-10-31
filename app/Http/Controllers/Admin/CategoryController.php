<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(CategoryRequest $request, CategoryService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.category.index', ['results' => $results]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request, CategoryService $service)
    {
        $results = ['status' => false];
        $results['status'] = (bool) $service->save($request->all());

        return $results;
    }

    public function edit(Request $request, CategoryService $service)
    {
        $results['detail'] = $service->getOne($request->category_id);

        return view('admin.category.edit', ['results' => $results]);
    }

    public function update(CategoryRequest $request, CategoryService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->category_id);

        return $results;
    }
}
