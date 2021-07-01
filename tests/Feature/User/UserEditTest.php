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
     *
     * @test
     */
    public function UserUpdate()
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
}