<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * フォロー処理
     *
     * @test
     */
    public function Follow()
    {
        // ユーザー認証およびDB対象レコードがないことを確認
        $user = User::find(1);
        $target = User::find(2);
        $this->actingAs($user);
        $this->assertAuthenticated()
            ->assertDatabaseMissing('follows', [
                'follower_id' => $user->id,
                'followee_id' => $target->id,
            ]);

        $this->put(route('users.follow', [
            'name' => $target->name,
        ]));
        $this->assertDatabaseHas('follows', [
            'follower_id' => $user->id,
            'followee_id' => $target->id,
        ]);
    }

    /**
     * フォロー解除
     *
     * @test
     */
    public function UnFollow()
    {
        $user = User::find(1);
        $target = User::find(2);
        $this->actingAs($user);
        $this->assertAuthenticated();

        $this->put(route('users.follow', [
            'name' => $target->name,
        ]));
        $this->assertDatabaseHas('follows', [
            'follower_id' => $user->id,
            'followee_id' => $target->id,
        ]);

        $this->delete(route('users.follow', [
            'name' => $target->name,
        ]));
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $user->id,
            'followee_id' => $target->id,
        ]);
    }

    /**
     * ゲスト状態でのフォロー処理
     * DBにデータが登録されないこと
     *
     * @test
     */
    public function GuestFollow()
    {
        // ユーザー認証およびDB対象レコードがないことを確認
        $user = User::find(1);
        $target = User::find(2);
        $this->assertGuest()
            ->assertDatabaseMissing('follows', [
                'follower_id' => $user->id,
                'followee_id' => $target->id,
            ]);

        $this->put(route('users.follow', [
            'name' => $target->name,
        ]));
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $user->id,
            'followee_id' => $target->id,
        ]);
    }
}