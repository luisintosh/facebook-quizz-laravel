<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuiz extends FormRequest
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
        return [
            'title' => 'required|min:10|max:150',
            'slug' => 'required|min:5|max:100',
            'description' => 'required',
            'resultTitle' => 'max:150',
            'resultDescription' => 'required',
            'coverImage' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
