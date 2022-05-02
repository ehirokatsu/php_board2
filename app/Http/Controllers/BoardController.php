<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
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


        $items = Board::all();
        return view('Board.index',['items' => $items]);
    }
    public function add(Request $request)
    {
       return view('Board.add');
    }
    
    public function create(Request $request)
    {
       $this->validate($request, Board::$rules);
       $person = new Board;
       $form = $request->all();
       unset($form['_token']);
       $person->fill($form)->save();
       return redirect('/board');
    }

}
