<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Board extends Model
{
    use HasFactory;

    protected $guarded = array('post_id');

    /************************************************
     * userテーブルとの結合
     * @param  void
     * @return 結合したテーブル
     ************************************************/
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

    /************************************************
     * replyテーブルとの結合
     * @param  void
     * @return 結合したテーブル
     ************************************************/
    public function reply()
    {
        return $this->hasOne('App\Models\reply','post_id', 'id');
    }

    /************************************************
     * 投稿画像のファイル名を取得する
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getBoardImageName() {

        //投稿画像の保存場所を取得する(public以下)
        $boardImagePath = \Config::get('filepath.boardImagePath');

        //拡張子の初期値
        $imageExtension = null;

        //対応する拡張子を決定する
        if (Storage::disk('local')->exists('public/' . $boardImagePath . $this->id . '.jpg')) {

            $imageExtension = '.jpg';

        } elseif (Storage::disk('local')->exists('public/' . $boardImagePath . $this->id . '.png')) {

            $imageExtension = '.png';

        } elseif (Storage::disk('local')->exists('public/' . $boardImagePath . $this->id . '.svg')) {

            $imageExtension = '.svg';

        } elseif (Storage::disk('local')->exists('public/' . $boardImagePath . $this->id . '.gif')) {

            $imageExtension = '.gif';

        } else {

            //該当しない場合
            return;
        }

        //ファイル名を返却する
        return $this->id . $imageExtension;
    }

    /************************************************
     * 投稿画像のファイル名を含むパスを取得する（storage以下）
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getBoardImagePath() {

        //configから保存場所を取得する
        $boardImagePath = \Config::get('filepath.boardImagePath');

        //当該投稿に画像が含まれている場合
        if ($this->getBoardImageName()) {

            //Viewで表示するためのパスを返却する
            return '/storage/'. $boardImagePath . $this->getBoardImageName();

        } else {

            return;

        }
    }


    /************************************************
     * 投稿したユーザー画像のパスを取得する
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getBoardUserImageName() {

        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //拡張子の初期値
        $imageExtension = null;

        //対応する拡張子を決定する
        if (Storage::disk('local')->exists('public/' . $userImagePath . $this->user_id . '.jpg')) {

            $imageExtension = '.jpg';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->user_id . '.png')) {

            $imageExtension = '.png';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->user_id . '.svg')) {

            $imageExtension = '.svg';

        } elseif (Storage::disk('local')->exists('public/' . $userImagePath . $this->user_id . '.gif')) {

            $imageExtension = '.gif';

        } else {

            //該当しない場合
            return '0.jpg';
        }

        return $this->user_id . $imageExtension;
    }

    /************************************************
     * 投稿したユーザーの画像ファイル名を含むパスを取得する
     * （storage以下）
     * @param  void
     * @return ユーザーの画像パス
     ************************************************/
    public function getBoardUserImagePath() {

        //configから保存場所を取得する
        $userImagePath = \Config::get('filepath.userImagePath');

        //当該投稿に画像が含まれている場合
        if ($this->getBoardUserImageName()) {

            //Viewで表示するためのパスを返却する
            return '/storage/'. $userImagePath . $this->getBoardUserImageName();

        } else {

            return;

        }
    }
}
