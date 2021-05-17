<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FailingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function test_failing()
    {

        $this->assertTrue(false);
    }
}