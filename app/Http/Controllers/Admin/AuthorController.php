<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index(Request $request, AuthorService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.author.index', ['results' => $results]);
    }

    public function edit(Request $request, AuthorService $service)
    {
        $results['detail'] = $service->getOne($request->author_id);

        return view('admin.author.edit', ['results' => $results]);
    }

    public function update(AuthorRequest $request, AuthorService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->author_id);

        return $results;
    }

    // 删除
    public function destroy(Request $request, AuthorService $service)
    {
        $results['status'] = $service->delete($request->author_id);

        return $results;
    }
}
