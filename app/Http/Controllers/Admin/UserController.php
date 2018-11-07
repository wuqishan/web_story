<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function login()
    {
        return view('admin.user.login');
    }

    public function doLogin(Request $request)
    {
        $username = $request->get('username');
        $password = md5($request->get('password'));
        $user = User::where('username', $username)->where('password', $password)->first();

        if (! empty($user)) {
            session(['user' => $user->toArray()]);
            return redirect()->route('admin.book.index');
        } else {
            return view('admin.user.login');
        }
    }

    public function logout(Request $request)
    {
        session(['user' => null]);

        return view('admin.user.login');
    }
}
