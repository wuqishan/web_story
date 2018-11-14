<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request, UserService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.user.index', ['results' => $results]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserRequest $request, UserService $service)
    {
        $results = ['status' => false];
        $results['status'] = (bool) $service->save($request->all());

        return $results;
    }

    public function edit(Request $request, UserService $service)
    {
        $results['detail'] = $service->getOne($request->user_id);

        return view('admin.user.edit', ['results' => $results]);
    }

    public function update(UserRequest $request, UserService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->user_id);

        return $results;
    }

    // 删除
    public function destroy(Request $request, UserService $service)
    {
        $results['status'] = $service->delete($request->user_id);

        return $results;
    }
}
