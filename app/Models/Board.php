<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * 投稿画像の保存場所パス（ファイル名を含む）を取得する（storage以下）
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getBoardImageStoragePath() {

        return \Util::getBoardImageStoragePath($this->id);

    }

    /************************************************
     * 投稿したユーザーのユーザー画像の保存場所パス
     * （ファイル名を含む）を取得する（storage以下）
     * @param  void
     * @return ユーザーの画像パス
     ************************************************/
    public function getBoardUserImageStoragePath() {

        return \Util::getUserImageStoragePath($this->user_id);

    }
}
