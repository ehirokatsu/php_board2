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
        var_dump($this->image);
        $rules = [

            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image',
        ];

        //自分のメールアドレスは検証から除外する
        if (!empty($this->userId)) {
            $rules['email'] = $rules['email'].','.$this->userId.'id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.string' => '名前は文字列で入力してください',
            'name.max' => '名前の最大値は255文字です',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.email' => 'メールアドレスの形式が間違っています',
            'email.max' => 'メールアドレスの最大値は255文字です',
            'email.unique' => 'メールアドレスが既に登録されています',
            'password.string' => 'パスワードは文字列で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.confirmed' => 'パスワード確認項目と一致しません',
            'image.image' => '画像ファイルを選択してください',
        ];
    }
}
