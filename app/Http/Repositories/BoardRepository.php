<?php

namespace App\Http\Repositories;

use App\Models\Board;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class BoardRepository implements BoardRepositoryInterface
{
    /************************************************
     * 一覧画面の表示
     * @param 
     * @return
     ************************************************/
    public function index()
    {
        //投稿された順番に変更し、1ページ10投稿まで表示する
        $boards = Board::with('user')->get();
        $boards = Board::with('reply')->get();
        $boards = Board::orderBy('id', 'desc')->simplePaginate(10);
        return $boards;
    }

    public function show($id)
    {
        //選択した投稿のIDから行を取得する
        $board = Board::with('user')->get();
        $board = board::findOrFail($id);
        return $board;
    }

    /************************************************
     * 投稿の登録画面
     * @param  無し
     * @return view /create
     ************************************************/
    public function create()
    {
        // 空の$boardを取得する
        $board = new board();

        return $board;
    }

    /************************************************
     * 投稿の登録処理
     * @param  $post_text 投稿テキスト
     * @return 登録した時のID
     ************************************************/
    public function store($post_text)
    {
        //boardテーブルに挿入する
        $lastInsertBoardId = \Util::insertBoard($post_text);

        return $lastInsertBoardId;
    }

    /************************************************
     * 投稿の編集画面
     * @param  $id 投稿ID
     * @return $board
     ************************************************/
    public function edit($id)
    {
        $board = board::findOrFail($id);
        return $board;
    }

        /************************************************
     * 投稿の更新処理
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function update($post_text, $id)
    {
        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        //選択した投稿のIDから行を取得する
        $board = board::findOrFail($id);

        //Boardテーブルに上書きする
        $board->post_text = $post_text;
        $board->send_date = $today;
        $board->save();
        
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
        $board = board::findOrFail($id);
        $board->delete();

        return;
    }
    /************************************************
     * 返信投稿の詳細画面
     * @param  $id 投稿ID
     * @return view /replyShow
     ************************************************/
    public function replyShow($id)
    {
        //先にwithで結合してからfindしないとエラーになる
        $board = Board::with('user')->get();
        $board = Board::findOrFail($id);

        return $board;
    }

    /************************************************
     * 返信投稿の登録処理
     * @param  $request->_src_id 返信元ID
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @return view /
     ************************************************/
    public function replyStore($post_text, $_src_id)
    {
        //boardテーブルに挿入する
        $lastInsertBoardId = \Util::insertBoard($post_text);

        //返信なのでreplyテーブルにinsertする
        $reply = new Reply;
        $reply->post_id = $lastInsertBoardId;
        $reply->src_post_id = $_src_id;
        $reply->save();

        return $lastInsertBoardId;
    }


}




