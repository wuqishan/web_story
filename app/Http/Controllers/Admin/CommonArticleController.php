<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommonArticleRequest;
use App\Services\CommonArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonArticleController extends Controller
{
    public function index(Request $request, CommonArticleService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.common_article.index', ['results' => $results]);
    }

    public function create()
    {
        return view('admin.common_article.create');
    }

    public function store(CommonArticleRequest $request, CommonArticleService $service)
    {
        $results = ['status' => false];
        $results['status'] = (bool) $service->save($request->all());

        return $results;
    }

    public function edit(Request $request, CommonArticleService $service)
    {
        $results['detail'] = $service->getOne($request->common_article_id);

        return view('admin.common_article.edit', ['results' => $results]);
    }

    public function update(CommonArticleRequest $request, CommonArticleService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->common_article_id);

        return $results;
    }

    // 删除
    public function destroy(Request $request, CommonArticleService $service)
    {
        $results['status'] = $service->delete($request->common_article_id);

        return $results;
    }
}
