<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    public function profile()
    {
        $user = Auth::user();
        return view('board/profile', compact('user'));
    }
    public function profileUpdate(UserRequest $request)
    {
        
        $user = Auth::user();
        
        echo('OK');
        if (!empty($request->name)) {
            $user->name = $request->name;
        }
        if (!empty($request->email)) {
            $user->email = $request->email;
        }
        if (!empty($request->password)
         && !empty($request->_confirmation)
         ) {
            if ($request->password === $request->_confirmation) {
                 $user->password = Hash::make($request->password);
            }
            
        }
        $user->save();

        //画像保存
        if (!empty($request->image)) {
            $request->image->storeAs('public/profile', $user->id . '.jpg');
        }
        
        return view('board/profile', compact('user'));
    }

    public function profileDelete($id)
    {

        //投稿を削除する
        $user = Auth::user();
        //$user = user::findOrFail($id);
        $user->delete();

        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists('public/profile/' . $id . '.jpg')) {
            Storage::disk('local')->delete('public/profile/' . $id . '.jpg');
        }

        return redirect("/login");
    }

}
