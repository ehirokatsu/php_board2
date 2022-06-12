<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /************************************************
     * ログインユーザの一覧画面の表示
     * @param 
     * @return view Board/user
     ************************************************/
    public function user()
    {
        //ログインユーザ情報を取得する
        $user = Auth::user();

        return view('/user', compact('user'));
    }

    /************************************************
     * ログインユーザの更新処理
     * @param  $request->name ユーザ名
     * @param  $request->email メールアドレス
     * @param  $request->password パスワード
     * @param  $request->password_confirmation パスワード確認
     * @param  $request->image ユーザ画像
     * @param  $id 投稿ID
     * @return view Board
     ************************************************/
    public function userUpdate(UserRequest $request)
    {
        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //ログインユーザ情報を取得する
        $user = Auth::user();
        
        //ユーザ名が入力されていれば更新する
        if (!empty($request->name)) {
            $user->name = $request->name;
        }

        //メールアドレスが入力されていれば更新する
        if (!empty($request->email)) {
            $user->email = $request->email;
        }

        //パスワードが入力されていれば更新する
        if (!empty($request->current_password)) {
            //現在のパスワードに一致するか検査する
            if (Hash::check($request->current_password, $user->password)) {
                if (!empty($request->password)
                && !empty($request->password_confirmation)
                ) {
                    if ($request->password === $request->password_confirmation) {
                        $user->password = Hash::make($request->password);
                    }
                }
            }
        }
        $user->save();

        //すでに画像投稿されている場合
        $file = $user->getuserImageName();
        //ユーザ画像が入力されていれば更新する
        if (!empty($request->image)) {

            //すでにユーザー画像が登録されている場合
            if (Storage::disk('local')->exists('public/' . $userImagePath . $user->getuserImageName())) {
                
                //0.jpgなら除外する
                if ($file !== '0.jpg') {
                    //前の画像を削除する
                    Storage::disk('local')->delete('public/' . $userImagePath . $user->getuserImageName());
                }
            }

            //画像保存する
            $request->image->storeAs('public/',$userImagePath . $user->id . '.' .$request->image->guessExtension());
        }

        //画像削除チェックボックスがONなら画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($request->image_delete
         && Storage::disk('local')->exists('public/' . $userImagePath . $user->getUserImageName())
         ) {
             
            //0.jpgなら除外する
            if ($file !== '0.jpg') {
                //投稿していた画像を削除する
                Storage::disk('local')->delete('public/' . $userImagePath . $user->getUserImageName());
            }
        }
        return redirect('/user')->with('message', '更新しました。');
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view Board
     ************************************************/
    public function userDestroy($id)
    {

        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //投稿を削除する
        $user = Auth::user();
        //$user = user::findOrFail($id);
        $user->delete();
        $file = $user->getuserImageName();
        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists('public/' . $userImagePath . $user->getUserImageName())) {

            //0.jpgなら除外する
            if ($file !== '0.jpg') {
                Storage::disk('local')->delete('public/' . $userImagePath . $user->getUserImageName());
            }
        }

        return redirect("/login");
    }

}
