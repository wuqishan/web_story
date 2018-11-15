<?php

namespace App\Http\Controllers\Admin;

use App\Services\ImportLogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportLogController extends Controller
{
    public function index(Request $request, ImportLogService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.import_log.index', ['results' => $results]);
    }

    public function show(Request $request, ImportLogService $service)
    {
        $import_log_id = $request->import_log_id;
        $results['detail'] = $service->getOne($import_log_id);
        $results['book'] = $service->getImportBook($results['detail']['content']);

        return $results;
    }
}
