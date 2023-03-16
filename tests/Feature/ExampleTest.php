<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

//factoryで使用
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;



    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        //ログイン画面に遷移可能なこと
        $response = $this->get('/login');
        $response->assertStatus(200);

        //登録画面に遷移可能なこと
        $response = $this->get('/register');
        $response->assertStatus(200);

        //ホーム画面は認証が必要なこと
        $response = $this->get('/');
        $response->assertStatus(302);

        //userを作成して認証できること
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/create');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/search');
        $response->assertStatus(200);

        

        //存在しないページは404エラーとなること
        $response = $this->get('/no_route');
        $response->assertStatus(404);




    }
}
