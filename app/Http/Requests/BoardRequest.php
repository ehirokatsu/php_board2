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
        if ($this->path() ===  'board' || $this->path() ===  'board/reply')
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_text' => 'required|max:140',

        ];
    }
    public function messages()
    {
        return [
            'post_text.required' => '投稿は必ず入力して下さい。',
            'post_text.max' => '投稿は140字以内です',
        ];
    }
}
