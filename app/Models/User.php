<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /************************************************
     * ログインユーザーの画像パスを取得する
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getUserImageName() {

        $userImagePath = \Config::get('filepath.userImagePath');

        //拡張子の初期値
        $imageExtension = null;

        //対応する拡張子を決定する
        if (Storage::disk('local')->exists('public/' . $userImagePath . $this->id . '.jpg')) {

            $imageExtension = '.jpg';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->id . '.png')) {

            $imageExtension = '.png';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->id . '.svg')) {

            $imageExtension = '.svg';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->id . '.gif')) {

            $imageExtension = '.gif';

        } else {

            //該当しない場合
            return '0.jpg';
        }

        return $this->id . $imageExtension;
    }
    /************************************************
     * ユーザーの画像ファイル名を含むパスを取得する
     * （storage以下）
     * @param  void
     * @return ユーザーの画像パス
     ************************************************/
    public function getUserImagePath() {

        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //当該投稿に画像が含まれている場合
        if ($this->getUserImageName()) {

            //Viewで表示するためのパスを返却する
            return '/storage/'. $userImagePath . $this->getUserImageName();

        } else {

            return;

        }
    }

}
