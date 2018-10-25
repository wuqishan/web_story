<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends  Controller
{
    public function index(Request $request)
    {
        return view('home.index.index');
    }

    public function article(Request $request)
    {
        $category = $request->category_id;

        return view('home.index.article');
    }
}
