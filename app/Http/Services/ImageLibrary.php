<?php

namespace App\Http\Services;

class ImageLibrary
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
     * 投稿画像を保存する
     * @param  $id 投稿ID
     * @param  $request 投稿画像
     * @return void
     ************************************************/
    public function boardImageStore($image, $filename)
    {
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        $image->storeAs('public/',$boardImageFolder . $filename);
    }
}