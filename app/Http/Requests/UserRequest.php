<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::currentRouteName();
        $rules = [];
        if ($route == 'admin.user.update') {
            $user_id = request()->user_id;
            $rules = [
                'username' => 'required|username|unique:user,username,' . $user_id,
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
                'nickname' => 'required|min:4|max:64',
                'email' => 'email'
            ];
        } else if ('admin.user.store') {
            $rules = [
                'username' => 'required|unique:user,username',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
                'nickname' => 'required|min:6|max:64',
                'email' => 'required|email'
            ];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'username.username' => '用户名不对',
            'username.required' => '用户名必须填写',
            'username.unique' => '该用户名已经存在',
            'password.required' => '密码必须填写且长度不能小于6位',
            'password.min' => '密码必须填写且长度不能小于6位',
            'password.confirmed' => '确认密码不正确',
            'password_confirmation.required' => '确认密码不能为空',
            'nickname.required' => '昵称必须填写且长度不能小于6位',
            'nickname.min' => '昵称必须填写且长度不能小于6位',
            'nickname.max' => '昵称必须填写且长度不能小于6位',
            'email.required' => '邮箱必须填写',
            'email.email' => '邮箱格式不正确'
        ];
    }
}
