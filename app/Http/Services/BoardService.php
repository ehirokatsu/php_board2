<?php

namespace App\Http\Services;

class BoardService
{
    /************************************************
     * 一覧画面の表示
     * @param 
     * @return 
     ************************************************/
    public function index()
    {
        $boardRepository = app('BoardRepositoryInterface');
        //ログインユーザ情報を取得する
        $user = \Auth::user();
        $boards = $boardRepository->index();
        $param = ['boards' => $boards, 'user' => $user];

        return $param;
    }

}
