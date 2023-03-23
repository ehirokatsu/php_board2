<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

//factoryで使用
use App\Models\User;
use App\Models\Board;

class ExampleTest extends TestCase
{
    //テスト用データベースを初期化する。これがないと以前のテストデータが残る
    use RefreshDatabase;



    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        //ログイン画面に遷移可能なこと。対象のViewファイルを表示すること
        $response = $this->get('/login');
        $response->assertStatus(200)->assertViewIs('auth.login');

        //登録画面に遷移可能なこと。対象のViewファイルを表示すること
        $response = $this->get('/register');
        $response->assertStatus(200)->assertViewIs('auth.register');

        //ホーム画面は認証が必要なこと。対象のViewファイルを表示すること
        $response = $this->get('/');
        $response->assertStatus(302);

        //userを作成して認証できること。対象のViewファイルを表示すること
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('.index');

        $response = $this->actingAs($user)->get('/create');
        $response->assertStatus(200)->assertViewIs('.create');

        $response = $this->actingAs($user)->get('/search');
        $response->assertStatus(200)->assertViewIs('.search');


        //存在しないページは404エラーとなること
        $response = $this->get('/no_route');
        $response->assertStatus(404);

        //ユーザー編集画面に遷移できること。対象のViewファイルを表示すること
        $response = $this->actingAs($user)->get('/user/1/edit');
        $response->assertStatus(200)->assertViewIs('.userEdit');

        //投稿データを100個生成する
        Board::factory()->count(100)->create();
        $num = rand(1, 100);
        
        //作成したテストデータをランダムで選択し詳細画面に遷移できること。対象のViewファイルを表示すること
        $response = $this->actingAs($user)->get('/'.$num);
        $response->assertStatus(200)->assertViewIs('.show');

        //作成したテストデータをランダムで選択し編集画面に遷移できること。対象のViewファイルを表示すること
        $response = $this->actingAs($user)->get('/'.$num.'/edit');
        $response->assertStatus(200)->assertViewIs('.edit');

        //作成したテストデータをランダムで選択し返信画面に遷移できること。対象のViewファイルを表示すること
        $response = $this->actingAs($user)->get('/'.$num.'/replyShow');
        $response->assertStatus(200)->assertViewIs('.replyShow');
        
        //boardsテーブルにレコードが100件あること
        $this->assertDatabaseCount('boards', 100);

        //テストデータを生成する
        User::factory()->create([
            'name' => 'AAA',
            'email' => 'BBB@CCC.com',
            'password' => 'AAAABBBB',
        ]);

        //生成したテストデータがDBに登録されていること
        $this->assertDatabaseHas('users', [
            'name' => 'AAA',
            'email' => 'BBB@CCC.com',
            'password' => 'AAAABBBB',
        ]);


    }
}
