<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {

        $username = $request->get('username');
        $password = md5($request->get('password'));
        $user = User::where('username', $username)->where('password', $password)->first();

        if (! empty($user)) {
            session(['user' => $user->toArray()]);
            return redirect()->route('update-book-index');
        } else {
            return view('login');
        }
    }
}
