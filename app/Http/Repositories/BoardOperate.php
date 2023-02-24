<?php

namespace App\Http\Repositories;

use App\Models\Board;

class BoardOperate
{
    /************************************************
    * 投稿をBoardテーブルにINSERTする
    * @param  $post_text 投稿テキスト
    * @return $board->id BoardテーブルにINSERTした時のID
    ************************************************/
    public function insertBoard($post_text)
    {
        //ログイン中のユーザ名を取得する
        $user = \Auth::user();
 
        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");
 
        //投稿内容をinsertする
        $board = new Board;
       
        //画像のみの投稿の場合は空文字にする
        if(empty($post_text)){
            $post_text = "";
        }
 
        //Boardテーブルに書き込む
        $board->post_text = $post_text;
        $board->send_date = $today;
        $board->user_id = $user->id;
        $board->save();
 
        return $board->id;
    }


}