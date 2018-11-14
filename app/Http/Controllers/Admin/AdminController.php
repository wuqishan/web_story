<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function login()
    {
        if (! empty(session('admin'))) {
            return redirect()->route('admin.admin.index');
        }

        return view('admin.admin.login');
    }

    public function doLogin(Request $request)
    {
        $username = $request->get('username');
        $password = md5($request->get('password'));
        $user = Admin::where('username', $username)->where('password', $password)->first();

        if (! empty($user)) {
            session(['admin' => $user->toArray()]);
            return redirect()->route('admin.admin.index');
        } else {
            return view('admin.admin.login');
        }
    }

    public function logout(Request $request)
    {
        session(['admin' => null]);

        return view('admin.admin.login');
    }
}
