<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーページ表示のテスト
     *
     * @test
     */
    public function ViewUserPageGuest()
    {
        $user = User::find(1);
        $response = $this->get(route('users.show', ['name' => $user->name]));
        $response->assertStatus(200)
            ->assertViewIs('users.show');
    }

    /**
     * ユーザーページ表示テスト(認証)
     *
     * @test
     */
    public function ViewUserAuth()
    {
        $user = User::find(1);
        $this->actingAs($user)->assertAuthenticated();
        $response = $this->get(route('users.show', ['name' => $user->name]));
        $response->assertStatus(200)
            ->assertViewIs('users.show');
    }

    /**
     * お気に入り記事表示
     *
     * @test
     */
    public function ViewUserFavorites()
    {
        $user = User::find(1);
        $response = $this->get(route('users.favorites', [
            'name' => $user->name,
        ]));

        $response->assertOk()
            ->assertViewIs('users.favorites');
    }
}