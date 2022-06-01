<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Boardimage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BoardRequest;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $sort = $request->sort;
        //$items = Person::orderBy($sort, 'asc')->simplePaginate(5);
        

        $boards = Board::with('user')->get();
        $boards = Board::with('post')->get();
        $boards = Board::with('reply')->get();
        $boards = Board::with('boardimage')->get();
        $boards = Board::simplePaginate(10);

        $param = ['boards' => $boards, 'sort' => $sort, 'user' => $user];

        return view('Board.index',$param);
    }

    public function edit($id)
    {
        $user = Auth::user();
        // DBよりURIパラメータと同じIDを持つboardの情報を取得
        $board = board::findOrFail($id);
  
        $param = ['board' => $board, 'user' => $user];
        // 取得した値をビュー「board/edit」に渡す
        return view('board/edit', $param);
    }
  
    public function destroy($id)
    {
        //投稿を削除する
        $board = board::findOrFail($id);
        $board->delete();

        //投稿に画像があれば削除する
        if (Storage::disk('local')->exists('public/images/' . $id . '.jpg')) {
            Storage::disk('local')->delete('public/images/' . $id . '.jpg');
        }

        return redirect("/board");
    }
    public function create()
    {

        $user = Auth::user();
        // 空の$boardを渡す
        $board = new board();

        $param = ['board' => $board, 'user' => $user];
        return view('board/create', $param);
    }
    
    public function replyShow($id)
    {
        //先にwithで結合してからfindしないとエラーになる
        $board = Board::with('post')->get();
        $board = Board::with('user')->get();
        $board = Board::with('boardimage')->get();
        $board = Board::findOrFail($id);

        $user = Auth::user();
        $param = ['board' => $board, 'user' => $user];

        return view('board/replyShow', $param);
    }

    public function store(BoardRequest $request)
    {

        //boardとpostテーブルに挿入する
        $lastInsertBoardId = $this->insertBoard($request->post_text);

        //画像保存
        if (!empty($request->image)) {
            $this->imageSave($lastInsertBoardId, $request);
        }

        return redirect("/board");
    }

    public function replyStore(BoardRequest $request)
    {
       
        //投稿元のreply_flagをtrueにする
        //post.phpにて主キー名を変更する必要あり
        $post = Post::findOrFail($request->_src_id);
        $post->reply_flag = true;
        $post->save();

        //boardとpostテーブルに挿入する
        $lastInsertBoardId = $this->insertBoard($request->post_text);

        //返信なのでreplyテーブルにinsertする
        $reply = new Reply;
        $reply->post_id = $lastInsertBoardId;
        $reply->src_post_id = $request->_src_id;
        $reply->save();
        
        
        //画像保存
        if (!empty($request->image)) {
            $this->imageSave($lastInsertBoardId, $request);
        }

        return redirect("/board");
    }

    public function update(BoardRequest $request, $id)
    {
        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        $board = board::findOrFail($id);
        $board->post_text = $request->post_text;
        $board->send_date = $today;
        $board->save();

        //画像がアップロードされている場合
        if (!empty($request->image)) {
            //すでに画像投稿されている場合
            if (Storage::disk('local')->exists('public/images/' . $id . '.jpg')) {
                //前の画像を削除する
                Storage::disk('local')->delete('public/images/' . $id . '.jpg');

            } else {

                //画像投稿されていない場合
                $boardimage = new Boardimage;
                $boardimage->post_id = $id;
                $boardimage->image_name = $id . '.jpg';
                $boardimage->save();
            }

            //画像保存する
            $request->image->storeAs('public/images', $id . '.jpg');

        }
        return redirect("/board");
    }


    public function show($id)
    {

        // DBよりURIパラメータと同じIDを持つboardの情報を取得
        $board = board::findOrFail($id);

        // 取得した値をビュー「board/edit」に渡す
        return view('board/show', compact('board'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('board/profile', compact('user'));
    }
    public function profileUpdate(Request $request)
    {

        
        exit('OK');
    }
    public function profileDelete()
    {
        exit('NG');
    }

    public function insertBoard($post_text)
    {
        //ログイン中のユーザ名を取得する
        $user = Auth::user();

        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        //投稿内容をinsertする
        $board = new Board;
        $board->post_text = $post_text;
        $board->send_date = $today;
        $board->user_id = $user->id;
        $board->save();

        //postテーブルにinsertする
        $post = new Post;
        $post->post_id = $board->id;
        $post->reply_flag = false;
        $post->save();
        
        return $board->id;

    }
    
    public function imageSave($lastInsertBoardId, $request)
    {
        $request->image->storeAs('public/images', $lastInsertBoardId . '.jpg');
        $boardimage = new Boardimage;
        $boardimage->post_id = $lastInsertBoardId;
        $boardimage->image_name = $lastInsertBoardId . '.jpg';
        $boardimage->save();
    }

}
