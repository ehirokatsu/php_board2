<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Post;
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
    
    public function store(BoardRequest $request)
    {
        $user_id = 1;

        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

        //$this->validate($request, Board::$rules);
        $board = new Board;

        $board->post_text = $request->post_text;
        $board->send_date = $today;
        $board->user_id = $user_id;
        $board->save();

        $post = new Post;
        $post->post_id = $board->id;
        $post->reply_flag = false;
        
        $post->save();

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
