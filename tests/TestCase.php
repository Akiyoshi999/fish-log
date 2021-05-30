<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * デフォルトのシーダーが各テスト前に実行するか
     *
     * @var boolean
     */
    protected $seed = true;
}