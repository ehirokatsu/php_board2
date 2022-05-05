<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function index(Request $request)
    {
/*
        $param = [
            'send_date' => '2022-04-17 21:03:16',
            'post_text' => 'test',
        ];
        DB::insert('insert into boards (send_date, post_text)
        values (:send_date, :post_text)', $param);

        $param = [
            'user_id' => 1,
            'post_id' => 1,
        ];
        DB::insert('insert into userboards (send_date, post_text)
        values (:send_date, :post_text)', $param);
*/


        //$items = Board::all();

        $items = Board::with('user')->get();
        $items = Board::with('post')->get();
        return view('Board.index',['items' => $items]);


    }
    public function add(Request $request)
    {
       return view('Board.add');
    }
    
    public function create(Request $request)
    {

        $user_id = 1;
        //現在日時を取得する
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");

       $this->validate($request, Board::$rules);
       $board = new Board;
       /*
       $form = $request->all();
       unset($form['_token']);
       $board->fill($form)
       */
       $board->post_text = $request->post_text;
       $board->send_date = $today;
       $board->user_id = $user_id;
       $board->save();

       $post = new Post;
       $post->post_id = $board->id;
       $post->reply_flag = false;

       
       $post->save();
       



       return redirect('/board');
    }

}
