<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\FriendLinkRequest;
use App\Services\FriendLinkService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendLinkController extends Controller
{
    public function index(Request $request, FriendLinkService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.friend_link.index', ['results' => $results]);
    }

    public function create()
    {
        return view('admin.friend_link.create');
    }

    public function store(FriendLinkRequest $request, FriendLinkService $service)
    {
        $results = ['status' => false];
        $results['status'] = (bool) $service->save($request->all());

        return $results;
    }

    public function edit(Request $request, FriendLinkService $service)
    {
        $results['detail'] = $service->getOne($request->friend_link_id);

        return view('admin.friend_link.edit', ['results' => $results]);
    }

    public function update(FriendLinkRequest $request, FriendLinkService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->friend_link_id);

        return $results;
    }

    // 删除
    public function destroy(Request $request, FriendLinkService $service)
    {
        $results['status'] = $service->delete($request->friend_link_id);

        return $results;
    }
}
