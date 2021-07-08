<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザー情報更新テスト
     * アイコンとユーザー名変更
     *
     * @test
     */
    public function User_All_Update()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->put(route('users.update', [
            'user' => $user,
            'name' => 'abcdefg',
            'icon' => 'fab fa-android'
        ]));

        $response->assertOk()->assertViewIs('users.show');
        $this->assertDatabaseHas('users', [
            'name' => 'abcdefg',
            'icon' => 'fab fa-android'
        ]);
    }

    /**
     * ユーザー情報更新テスト
     * ユーザー名変更
     *
     * @test
     */
    public function User_Username_Update()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->put(route('users.update', [
            'user' => $user,
            'name' => 'abc',
        ]));

        $response->assertOk()->assertViewIs('users.show');
        $this->assertDatabaseHas('users', [
            'name' => 'abc',
        ]);
    }

    /**
     * ユーザー情報更新テスト
     * アイコンのみ変更
     *
     * @test
     */
    public function User_Icon_Update()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->put(route('users.update', [
            'user' => $user,
            'icon' => 'fas fa-dove'
        ]));

        $response->assertOk()->assertViewIs('users.show');
        $this->assertDatabaseHas('users', [
            'icon' => 'fas fa-dove'
        ]);
    }
}