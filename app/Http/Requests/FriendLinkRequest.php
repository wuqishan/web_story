<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class FriendLinkRequest extends FormRequest
{
    public $rules = [
        'admin.friend_link.store' => [
            'title' => 'required',
            'link' => 'required',
            'orderby' => 'required|integer',
            'deleted' => 'required|in:1,2'
        ],
        'admin.friend_link.update' => [
            'title' => 'required',
            'link' => 'required',
            'orderby' => 'required|integer',
            'deleted' => 'required|in:1,2'
        ]
    ];

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
        if (isset($this->rules[$route])) {
            $rules = $this->rules[$route];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '标题必须填写',
            'link.required' => '链接地址必须填写',
            'orderby.required' => '排序必须填写',
            'orderby.integer' => '排序必须是整数',
            'deleted.required' => '链接状态必须选择',
            'deleted.in' => '链接状态选择有误',
        ];
    }
}
