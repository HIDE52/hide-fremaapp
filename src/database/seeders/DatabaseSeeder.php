<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => \Hash::make('password'),
        ]);

        $this->call([
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
        ]);

        if (app()->isLocal()) {
            $this->call(DeveloperSeeder::class);
        }
    }
}
