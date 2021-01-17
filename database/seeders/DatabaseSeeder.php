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
         \App\Models\User::factory()->create([
             'name' => 'jake',
             'email' => 'jakeshepherd98@gmail.com',
             'password' => '$2y$10$mJYZB0nTFwGfBT6Z61YQiO2YiP3YZpZaU6wpMUKBor1UK0KfwMLrm',
         ]);
    }
}
