<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * ユーザー登録ができるかの確認
     *
     * @test
     */
    public function test_userRegister()
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