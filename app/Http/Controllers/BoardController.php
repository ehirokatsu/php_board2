<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;
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
        $param = ['boards' => $boards, 'sort' => $sort, 'user' => $user];

        return view('Board.index',$param);
    }

    public function edit($id)
    {
        // DBよりURIパラメータと同じIDを持つboardの情報を取得
        $board = board::findOrFail($id);
  
        // 取得した値をビュー「board/edit」に渡す
        return view('board/edit', compact('board'));
    }
  
  
    public function destroy($id)
    {
        $board = board::findOrFail($id);
        $board->delete();
    
        return redirect("/board");
    }
    public function create()
    {
        // 空の$boardを渡す
        $board = new board();
        return view('board/create', compact('board'));
    }
    
    public function reply($id)
    {
        //先にwithで結合してからfindしないとエラーになる
        $board = Board::with('post')->get();
        $board = Board::with('user')->get();
        $board = Board::findOrFail($id);
        //
        return view('board/reply', compact('board'));
    }

    public function store(BoardRequest $request)
    {
        $user = Auth::user();

        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        //$this->validate($request, Board::$rules);
        $board = new Board;

        $board->post_text = $request->post_text;
        $board->send_date = $today;
        $board->user_id = $user->id;
        $board->save();

        $post = new Post;
        $post->post_id = $board->id;
        $post->reply_flag = false;
        
        $post->save();

        return redirect("/board");
    }

    public function replyStore(BoardRequest $request)
    {
        $user = Auth::user();
        //投稿元のreplyfragをtrueにする
        //post.phpｍにて主キー名を変更する必要あり
        $post = Post::findOrFail($request->_src_id);
        $post->reply_flag = true;
        $post->save();

        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");
        //boardテーブルをinsertする
        $board = new Board;
        $board->post_text = $request->post_text;
        $board->send_date = $today;
        $board->user_id = $user->id;
        $board->save();

        //postテーブルをinsertする
        $post = new Post;
        $post->post_id = $board->id;
        $post->reply_flag = false;
        $post->save();

        //replyテーブルをinsertする
        $reply = new Reply;
        $reply->post_id = $board->id;
        $reply->src_post_id = $request->_src_id;
        $reply->save();
        
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
    
        return redirect("/board");
    }
    
}
