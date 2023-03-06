<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BoardRequest;
use App\Http\Services\BoardService;
use App\Http\Repositories\BoardRepositoryInterface;

class BoardController extends Controller
{

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    /************************************************
     * 一覧画面の表示
     * @param 
     * @return view /index
     ************************************************/
    public function index(Request $request)
    {
        //boardService = app('BoardService');
        $param = $this->boardService->index();

        return view('/index',$param);
    }

    /************************************************
     * 各投稿の詳細画面
     * @param  $id 投稿ID
     * @return view /show
     ************************************************/
    public function show($id)
    {
        $param = $this->boardService->show($id);
        return view('/show', $param);
    }

    /************************************************
     * 投稿の登録画面
     * @param  無し
     * @return view /create
     ************************************************/
    public function create()
    {
        $param = $this->boardService->create();
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

        $this->boardService->store($request->post_text, $request->image);
        return redirect("/");
    }

    /************************************************
     * 投稿の編集画面
     * @param  $id 投稿ID
     * @return view /edit
     ************************************************/
    public function edit($id)
    {
        $param = $this->boardService->edit($id);

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
        //画像のみの投稿の場合は空文字にする
        if(empty($request->post_text)){
            $request->post_text = "";
        }
        $this->boardService->update($request->post_text, $id, $request->image, $request->image_delete);

        return redirect("/");
    }

    /************************************************
     * 投稿の削除処理
     * @param  $id 投稿ID
     * @return view /
     ************************************************/
    public function destroy($id)
    {
        $this->boardService->destroy($id);

        return redirect("/");
    }

    /************************************************
     * 返信投稿の詳細画面
     * @param  $id 投稿ID
     * @return view /replyShow
     ************************************************/
    public function replyShow($id)
    {
        $param = $this->boardService->replyShow($id);

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
        $this->boardService->replyStore($request->post_text, $request->_src_id, $request->image);

        return redirect("/");
    }

    /************************************************
     * 検索画面
     * @param  
     * @return 
     ************************************************/
    public function search(Request $request)
    {
        $param = $this->boardService->search($request->searchWord);

        return view('/search',$param);
    }

}
