<?php

namespace App\Http\Controllers\Admin;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(DashboardService $service)
    {
        $results['book'] = $service->getBooksPie();

        return view('admin.index.index', ['results' => $results]);
    }

    public function table(DashboardService $service)
    {
        $results['book'] = $service->getBooksTable();
//dd($results);
        return view('admin.index.table', ['results' => $results]);
    }
}
