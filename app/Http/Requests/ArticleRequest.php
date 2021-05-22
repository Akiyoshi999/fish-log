<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required | string | max:50',
            'date' => 'required | date',
            'place' => 'required | string',
            'weather' => 'required | string',
            'tide' => 'string',
            'fish' => 'required |string',
            'temperature' => 'int | between:-10,50',
            'length' => 'int | between:0,200',
            'comment' => 'string | max:500',
        ];
    }
}