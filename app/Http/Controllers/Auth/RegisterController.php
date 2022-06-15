<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //画像保存
        if (!empty($data['image'])) {
            $data['image']->storeAs('public/',$userImagePath . $user->id . '.' .$data['image']->guessExtension());
        }

        return $user;
    }

    /************************************************
     * ログインユーザの一覧画面の表示
     * @param  $id ユーザーID
     * @return view userEdit
     ************************************************/
    public function edit($id)
    {
        //ログインユーザ情報を取得する
        $user = user::findOrFail($id);

        return view('/userEdit', compact('user'));
    }

    /************************************************
     * ログインユーザの更新処理
     * @param  $request->name ユーザー名
     * @param  $request->email メールアドレス
     * @param  $request->current_password 現在のパスワード
     * @param  $request->password 新しいパスワード
     * @param  $request->password_confirmation パスワード確認
     * @param  $request->image ユーザー画像
     * @param  $id ユーザーID
     * @return view userEdit
     ************************************************/
    public function update(UserRequest $request, $id)
    {
        //ログインユーザ情報を取得する
        $user = user::findOrFail($id);

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
            if (\Hash::check($request->current_password, $user->password)) {
                if (!empty($request->password)
                && !empty($request->password_confirmation)
                ) {
                    if ($request->password === $request->password_confirmation) {
                        $user->password = \Hash::make($request->password);
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
            if (\Storage::disk('local')->exists($userImagePath)) {
                
                //前の画像を削除する
                \Storage::disk('local')->delete($userImagePath);
            }

            //新しいユーザー画像保存する
            $request->image->storeAs('public/',$userImageFolder . $user->id . '.' .$request->image->guessExtension());
        }

        //画像削除チェックボックスがONならユーザー画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($request->image_delete
         && \Storage::disk('local')->exists($userImagePath)
         ) {
            //投稿していた画像を削除する
            \Storage::disk('local')->delete($userImagePath);
        }

        return view('/userEdit', compact('user'));
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view login
     ************************************************/
    public function destroy($id)
    {

        //configから保存場所を取得する
        $userImageFolder = \Config::get('filepath.userImageFolder');

        //ユーザーテーブルから削除する
        $user = \Auth::user();
        $user = user::findOrFail($id);
        $user->delete();

        //ユーザー画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $userImageFolder);

        //ユーザー画像の保存場所
        $userImagePath = 'public/' . $userImageFolder . $imageName;

        //投稿に画像があれば削除する
        if (\Storage::disk('local')->exists($userImagePath)) {

            \Storage::disk('local')->delete($userImagePath);
        }

        return redirect("/login");
    }
}
