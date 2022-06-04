<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
        if ($this->path() ===  'board' || $this->path() ===  'board/reply')
        {
            return true;

        } else {
            return false;
        }
        */
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
            'post_text' => 'max:140',
        ];
    }
    public function messages()
    {
        return [
            'post_text.max' => '投稿内容は140字以内です',
        ];
    }
}
