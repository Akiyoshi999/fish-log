<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state([
                'name' => 'ubuntu',
                'email' => 'ubuntu@test.com',
            ])
            ->create();
        User::factory(2)->create();
    }
}