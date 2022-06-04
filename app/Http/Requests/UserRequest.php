<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'email' => 'email',
            'password' => 'confirmed',
        ];
    }
    public function messages()
    {
        return [
            'email' => 'メールアドレスの形式が間違っています',
            'password.confirmed' => 'パスワード確認項目と一致しません',
        ];
    }
}
