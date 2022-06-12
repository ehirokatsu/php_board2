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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //テキスト文と画像いずれか一方が投稿されていればOKにする
        //required_withoutをimageにも付与すると、同じエラー文が表示されるので
        //post_textのみに付与する
        return [
            'post_text' => 'nullable|required_without:image|max:140|string',
            'image' => 'nullable|image|mimes:jpg,png,svg,gif|max:1024',
        ];
    }
    public function messages()
    {
        return [

            'post_text.required_without' => 'テキストか画像いずれかを入力してください',
            'post_text.string' => '投稿は文字列で入力してください',
            'post_text.max' => '投稿の最大値は140文字です',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '指定された拡張子（JPG,PNG,GIF,SVG）ではありません。',
        ];
    }
}
