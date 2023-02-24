<?php

namespace App\Http\Services;

use App\Http\Repositories\BoardRepositoryInterface;

class BoardService
{

    public function __construct(BoardRepositoryInterface $boardRepositoryInterface)
    {
        $this->boardRepositoryInterface = $boardRepositoryInterface;
    }

    /************************************************
     * 一覧画面の表示
     * @param 無し
     * @return $board, $user
     ************************************************/
    public function index()
    {
       //$boardRepository = app('BoardRepositoryInterface');
        //ログインユーザ情報を取得する
        $user = \Auth::user();
        $boards = $this->boardRepositoryInterface ->index();
        $param = ['boards' => $boards, 'user' => $user];

        return $param;
    }

    /************************************************
     * 各投稿の詳細画面
     * @param  $id 投稿ID
     * @return $board, $user
     ************************************************/
    public function show($id)
    {
        //Navバー表示のためログインユーザ情報を渡す
        $user = \Auth::user();

        $board = $this->boardRepositoryInterface ->show($id);
        $param = ['board' => $board, 'user' => $user];
        return $param;
    }

    /************************************************
     * 投稿の登録画面
     * @param  無し
     * @return $board, $user
     ************************************************/
    public function create()
    {
        //ログインユーザ情報を取得する
        $user = \Auth::user();

        $board = $this->boardRepositoryInterface ->create();
        $param = ['board' => $board, 'user' => $user];
        return $param;
    }

    /************************************************
     * 投稿の登録処理
     * @param  $post_text 投稿テキスト
     * @param  $image 投稿画像
     * @return 
     ************************************************/
    public function store($post_text, $image)
    {
        //boardテーブルに挿入する
        $lastInsertBoardId = $this->boardRepositoryInterface->store($post_text);

        //画像も投稿されていれば保存する
        if (!empty($image)) {
            \Util::boardImageStore($image, $lastInsertBoardId. '.' .$image->guessExtension());
        }

        return;
    }

    /************************************************
     * 投稿の編集画面
     * @param  $id 投稿ID
     * @return 
     ************************************************/
    public function edit($id)
    {
        //ログインユーザ情報を取得する
        $user = \Auth::user();

        //選択した投稿のIDから行を取得する
        $board = $this->boardRepositoryInterface->edit($id);
  
        $param = ['board' => $board, 'user' => $user];
        
        return $param;
    }

        /************************************************
     * 投稿の更新処理
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function update($post_text, $id, $image, $image_delete)
    {
        //選択した投稿のIDから行を取得する
        $board = $this->boardRepositoryInterface->update($post_text, $id);

        //configから投稿画像の保存フォルダーを取得する
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        //投稿画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $boardImageFolder);

        //投稿画像の保存場所
        $boardImagePath = 'public/' . $boardImageFolder . $imageName;

        //画像がアップロードされている場合
        if (!empty($image)) {

            //すでに画像投稿されている場合
            if (\Storage::disk('local')->exists($boardImagePath)) {

                //前の画像を削除する
                \Storage::disk('local')->delete($boardImagePath);
            }

            //新しい投稿画像を保存する
            \Util::boardImageStore($image, $id. '.' .$image->guessExtension());

        }

        //画像削除チェックボックスがONなら画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($image_delete
         && \Storage::disk('local')->exists($boardImagePath)
         ) {
            //投稿していた画像を削除する
            \Storage::disk('local')->delete($boardImagePath);
        }
        
        return;
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function destroy($id)
    {
        //投稿を削除する
        $this->boardRepositoryInterface->destroy($id);

        //configから投稿画像の保存フォルダーを取得する
        $boardImageFolder = \Config::get('filepath.boardImageFolder');


        //投稿画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $boardImageFolder);

        //投稿画像の保存場所
        $boardImagePath = 'public/' . $boardImageFolder . $imageName;

        //投稿に画像があれば削除する
        if (\Storage::disk('local')->exists($boardImagePath)) {

            \Storage::disk('local')->delete($boardImagePath);
        }

        return redirect("/");
    }

    /************************************************
     * 返信投稿の詳細画面
     * @param  $id 投稿ID
     * @return view /replyShow
     ************************************************/
    public function replyShow($id)
    {
        $board = $this->boardRepositoryInterface->replyShow($id);

        //Navバー表示のためログインユーザ情報を渡す
        $user = \Auth::user();
        $param = ['board' => $board, 'user' => $user];

        return $param;
    }

    /************************************************
     * 返信投稿の登録処理
     * @param  $request->_src_id 返信元ID
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @return view /
     ************************************************/
    public function replyStore($post_text, $_src_id, $image)
    {
        //boardテーブルに挿入する
        $lastInsertBoardId = $this->boardRepositoryInterface->replyStore($post_text, $_src_id);

        //画像も投稿されていれば保存する
        if (!empty($image)) {
            \Util::boardImageStore($image, $lastInsertBoardId. '.' .$image->guessExtension());
        }

        return redirect("/");
    }
}