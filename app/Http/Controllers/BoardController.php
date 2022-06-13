<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BoardRequest;
use Illuminate\Support\Facades\Auth;


class BoardController extends Controller
{

    /************************************************
     * 一覧画面の表示
     * @param 
     * @return view /index
     ************************************************/
    public function index(Request $request)
    {
        //\Util::hello();
        //ログインユーザ情報を取得する
        $user = Auth::user();

        //投稿された順番に変更し、1ページ10投稿まで表示する
        $boards = Board::with('user')->get();
        $boards = Board::with('reply')->get();
        $boards = Board::orderBy('id', 'desc')->simplePaginate(10);

        $param = ['boards' => $boards, 'user' => $user];

        return view('/index',$param);
    }

    /************************************************
     * 各投稿の詳細画面
     * @param  $id 投稿ID
     * @return view /show
     ************************************************/
    public function show($id)
    {

        //選択した投稿のIDから行を取得する
        $board = board::findOrFail($id);

        //Navバー表示のためログインユーザ情報を渡す
        $user = Auth::user();

        $param = ['board' => $board, 'user' => $user];
        return view('/show', $param);
    }

    /************************************************
     * 投稿の登録画面
     * @param  無し
     * @return view /create
     ************************************************/
    public function create()
    {
        //ログインユーザ情報を取得する
        $user = Auth::user();

        // 空の$boardを取得する
        $board = new board();

        $param = ['board' => $board, 'user' => $user];
        return view('/create', $param);
    }

    /************************************************
     * 投稿の登録処理
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @return view /
     ************************************************/
    public function store(BoardRequest $request)
    {

        //boardテーブルに挿入する
        $lastInsertBoardId = $this->insertBoard($request->post_text);

        //画像も投稿されていれば保存する
        if (!empty($request->image)) {
            $this->imageSave($lastInsertBoardId, $request);
        }

        return redirect("/");
    }

    /************************************************
     * 投稿の編集画面
     * @param  $id 投稿ID
     * @return view /edit
     ************************************************/
    public function edit($id)
    {
        //ログインユーザ情報を取得する
        $user = Auth::user();

        //選択した投稿のIDから行を取得する
        $board = board::findOrFail($id);
  
        $param = ['board' => $board, 'user' => $user];
        
        return view('/edit', $param);
    }

    /************************************************
     * 投稿の更新処理
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function update(BoardRequest $request, $id)
    {
        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        //選択した投稿のIDから行を取得する
        $board = board::findOrFail($id);

        //画像のみの投稿の場合は空文字にする
        if(empty($request->post_text)){
            $request->post_text = "";
        }

        //Boardテーブルに上書きする
        $board->post_text = $request->post_text;
        $board->send_date = $today;
        $board->save();

        //configから投稿画像の保存フォルダーを取得する
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        //投稿画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $boardImageFolder);

        //投稿画像の保存場所
        $boardImagePath = 'public/' . $boardImageFolder . $imageName;

        //画像がアップロードされている場合
        if (!empty($request->image)) {

            //すでに画像投稿されている場合
            if (Storage::disk('local')->exists($boardImagePath)) {

                //前の画像を削除する
                Storage::disk('local')->delete($boardImagePath);
            }

            //新しい投稿画像ｗｐ保存する
            $request->image->storeAs('public/',$boardImageFolder . $board->id . '.' .$request->image->guessExtension());
        }

        //画像削除チェックボックスがONなら画像を削除する
        //$request->image_deleteにはvalue値が格納される
        if ($request->image_delete
         && Storage::disk('local')->exists($boardImagePath)
         ) {
            //投稿していた画像を削除する
            Storage::disk('local')->delete($boardImagePath);
        }
        
        return redirect("/");
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function destroy($id)
    {
        //configから投稿画像の保存フォルダーを取得する
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        //投稿を削除する
        $board = board::findOrFail($id);
        $board->delete();

        //投稿画像のファイル名を取得する
        $imageName = \Util::getImageName($id, $boardImageFolder);

        //投稿画像の保存場所
        $boardImagePath = 'public/' . $boardImageFolder . $imageName;

        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists($boardImagePath)) {

            Storage::disk('local')->delete($boardImagePath);
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
        //先にwithで結合してからfindしないとエラーになる
        $board = Board::with('user')->get();
        $board = Board::findOrFail($id);

        //Navバー表示のためログインユーザ情報を渡す
        $user = Auth::user();
        $param = ['board' => $board, 'user' => $user];

        return view('/replyShow', $param);
    }

    /************************************************
     * 返信投稿の登録処理
     * @param  $request->_src_id 返信元ID
     * @param  $request->post_text 投稿テキスト
     * @param  $request->image 投稿画像
     * @return view /
     ************************************************/
    public function replyStore(BoardRequest $request)
    {
        //boardテーブルに挿入する
        $lastInsertBoardId = $this->insertBoard($request->post_text);

        //返信なのでreplyテーブルにinsertする
        $reply = new Reply;
        $reply->post_id = $lastInsertBoardId;
        $reply->src_post_id = $request->_src_id;
        $reply->save();
        
        //投稿に画像があれば保存する
        if (!empty($request->image)) {
            $this->imageSave($lastInsertBoardId, $request);
        }

        return redirect("/");
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
     * @param  $request->image 投稿画像
     * @return void
     ************************************************/
    public function imageSave($id, $request)
    {
        $boardImageFolder = \Config::get('filepath.boardImageFolder');

        $request->image->storeAs('public/',$boardImageFolder . $id . '.' .$request->image->guessExtension());
    }
}
