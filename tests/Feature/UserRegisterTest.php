<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;


    /**
     * ログイン画面を表示
     *
     * @test
     */
    public function LoginView()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $this->assertGuest();
    }

    /**
     * 記事投稿画面アクセス(ログイン画面へリダイレクト)
     *
     * @test
     */
    public function NonLoginAccess()
    {
        $response = $this->get('/articles/create');
        $response->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * ログインできるかのテスト
     *
     * @test
     */
    public function Login()
    {
        $response = $this->post(route('login'), [
            'email' => 'ubuntu@test.com',
            'password' => 'password',
        ]);
        $response->assertStatus(302)
            ->assertRedirect('/');
        $this->assertAuthenticated();
    }

    /**
     * ユーザー登録ができるかの確認
     *
     * @test
     */
    public function Register()
    {
        $email = 'email@example.com';
        $this->post(route('register'), [
            'name' => 'user',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'user',
            'email' => $email
        ]);
    }
}