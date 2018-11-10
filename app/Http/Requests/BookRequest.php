<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class BookRequest extends FormRequest
{
    public $rules = [
        'admin.book.store' => [
            'url' => 'required',
            'category_id' => 'required'
        ],
        'admin.book.update' => [
//            'name' => 'required',
//            'url' => 'required'
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
            'url.required' => '小说所属url必须填写',
            'category_id.required' => '小说分类必须选择',
        ];
    }
}
