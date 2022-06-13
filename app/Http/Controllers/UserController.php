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

        //configからユーザー画像の保存フォルダーを取得する
        $userImageFolder = \Config::get('filepath.userImageFolder');

        //ユーザー画像のファイル名を取得する
        $imageName = \Util::getImageName($user->id, $userImageFolder);

        //ユーザー画像の保存場所
        $userImagePath = 'public/' . $userImageFolder . $imageName;

        //新しいユーザー画像が入力されている場合
        if (!empty($request->image)) {

            //すでにユーザー画像が登録されている場合
            if (Storage::disk('local')->exists($userImagePath)) {
                
                //前の画像を削除する
                Storage::disk('local')->delete($userImagePath);
            }

            //新しいユーザー画像保存する
            $request->image->storeAs('public/',$userImageFolder . $user->id . '.' .$request->image->guessExtension());
        }

        //画像削除チェックボックスがONならユーザー画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($request->image_delete
         && Storage::disk('local')->exists($userImagePath)
         ) {
            //投稿していた画像を削除する
            Storage::disk('local')->delete($userImagePath);
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
        $userImageFolder = \Config::get('filepath.userImageFolder');

        //ユーザーテーブルから削除する
        $user = Auth::user();
        $user = user::findOrFail($id);
        $user->delete();

        //ユーザー画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $userImageFolder);

        //ユーザー画像の保存場所
        $userImagePath = 'public/' . $userImageFolder . $imageName;

        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists($userImagePath)) {

            Storage::disk('local')->delete($userImagePath);
        }

        return redirect("/login");
    }

}
