<?php
namespace App\MyClasses;

use Illuminate\Support\Facades\Auth;
use App\Models\Board;

class Util
{

    /************************************************
     * 画像の拡張子を含むファイル名を取得する
     * @param $id ユーザー、または投稿ＩＤ
     * @param $imageFolder 画像の保存フォルダー
     * @return 画像ファイル名。
     ************************************************/
    public function getImageName($id, $imageFolder) {

        //拡張子の初期値
        $imageExtension = null;

        //対応する拡張子を決定する
        if (\Storage::disk('local')->exists('public/' . $imageFolder . $id . '.jpg')) {

            $imageExtension = '.jpg';

        } elseif (\Storage::disk('local')->exists('public/' . $imageFolder . $id . '.png')) {

            $imageExtension = '.png';

        } elseif (\Storage::disk('local')->exists('public/' . $imageFolder . $id . '.svg')) {

            $imageExtension = '.svg';

        } elseif (\Storage::disk('local')->exists('public/' . $imageFolder . $id . '.gif')) {

            $imageExtension = '.gif';

        } else {

            //該当しない場合
            return;
        }

        return $id . $imageExtension;
    }


	/************************************************
     * 投稿したユーザーの画像ファイル名を含むパスを取得する
     * （storage以下）
     * @param  void
     * @return ユーザーの画像パス
     ************************************************/
    public function getUserImageStoragePath($id) {

        //configから保存場所を取得する
        $userImageFolder = \Config::get('filepath.userImageFolder');
        $userImageStoragePath = '/storage/'. $userImageFolder;
        $imageName = $this->getImageName($id, $userImageFolder);

        //当該投稿に画像が含まれている場合
        if ($imageName) {

            //Viewで表示するためのパスを返却する
            return $userImageStoragePath . $imageName;

        } else {

        //ユーザー画像が登録されていなければデフォルト画像を表示する。
        return $userImageStoragePath . '0.jpg';
        }
    }


    /************************************************
     * 投稿画像のファイル名を含むパスを取得する（storage以下）
     * @param  void
     * @return 投稿画像のパス
     ************************************************/
    public function getBoardImageStoragePath($id) {

        //configから保存場所を取得する
        $boardImageFolder = \Config::get('filepath.boardImageFolder');
        $boardImageStoragePath = '/storage/'. $boardImageFolder;
        $imageName = $this->getImageName($id, $boardImageFolder);

        //当該投稿に画像が含まれている場合
        if ($imageName) {

            //Viewで表示するためのパスを返却する
            return $boardImageStoragePath . $imageName;

        } else {

            return;

        }
    }
    
    /************************************************
    * 投稿をBoardテーブルにINSERTする
    * @param  $post_text 投稿テキスト
    * @return $board->id BoardテーブルにINSERTした時のID
    ************************************************/
   public function insertBoard($post_text)
   {
       //ログイン中のユーザ名を取得する
       $user = Auth::user();

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


    /************************************************
     * 投稿画像を保存する
     * @param  $id 投稿ID
     * @param  $request 投稿画像
     * @return void
     ************************************************/
    public function boardImageStore($id, $request)
    {
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        $request->image->storeAs('public/',$boardImageFolder . $id . '.' .$request->image->guessExtension());
    }
}