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
        if (!empty($request->password)
         && !empty($request->password_confirmation)
         ) {
            if ($request->password === $request->password_confirmation) {
                 $user->password = Hash::make($request->password);
            }
        }
        $user->save();

        //ユーザ画像が入力されていれば更新する
        if (!empty($request->image)) {
            $request->image->storeAs('public/user', $user->id . '.jpg');
        }

        //画像削除チェックボックスがONなら画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($request->image_delete
         && Storage::disk('local')->exists('public/user/' . $user->id . '.jpg')
         ) {
             
            //投稿していた画像を削除する
            Storage::disk('local')->delete('public/user/' . $user->id . '.jpg');
        }
        //return view('/user', compact('user'))->with('message', '更新しました。');
        return redirect('/user')->with('message', '更新しました。');
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view Board
     ************************************************/
    public function userDestroy($id)
    {

        //投稿を削除する
        $user = Auth::user();
        //$user = user::findOrFail($id);
        $user->delete();

        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists('public/user/' . $id . '.jpg')) {
            Storage::disk('local')->delete('public/user/' . $id . '.jpg');
        }

        return redirect("/login");
    }

}
