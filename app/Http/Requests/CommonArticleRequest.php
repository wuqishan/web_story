<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CommonArticleRequest extends FormRequest
{
    public $rules = [
        'admin.common_article.store' => [
            'title' => 'required',
            'orderby' => 'required|integer',
            'content' => 'required',
        ],
        'admin.common_article.update' => [
            'title' => 'required',
            'orderby' => 'required|integer',
            'content' => 'required',
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
            'title.required' => '文章标题必须填写',
            'orderby.required' => '文章排序必须填写',
            'orderby.integer' => '文章排序必须为整数',
            'content.required' => '文章内容必须填写',
        ];
    }
}
