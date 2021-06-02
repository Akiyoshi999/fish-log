<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 選択したタグのみのViewが表示されること
     *
     * @test
     */
    public function ViewTag()
    {
        $tag = Tag::find(1);
        $response = $this->get(route('tags.show', [
            'name' => $tag->name,
        ]));
        $response->assertOk()->assertViewIs('tags.show');
    }
}