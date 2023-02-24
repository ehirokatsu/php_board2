<?php

namespace App\Http\Repositories;

interface BoardRepositoryInterface
{
    /************************************************
     * 一覧画面の表示
     * @param 
     * @return view /index
     ************************************************/
    public function index();

    public function show($id);
    public function create();
    public function store($post_text);
    public function edit($id);
    public function update($post_text, $id);
    public function destroy($id);
    public function replyShow($id);
    public function replyStore($post_text, $_src_id);

}




