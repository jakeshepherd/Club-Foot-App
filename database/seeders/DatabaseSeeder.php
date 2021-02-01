<?php

namespace Database\Seeders;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
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
         $user = \App\Models\User::factory()->create([
             'name' => 'Jake',
             'email' => 'jakeshepherd98@gmail.com',
             'password' => '$2y$10$mJYZB0nTFwGfBT6Z61YQiO2YiP3YZpZaU6wpMUKBor1UK0KfwMLrm',
             'time_goal' => 15*60
         ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-3 days -11 hours'),
            'end_time' => Carbon::parse('-3 days +11 hours'),
            'duration' => 11 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-2 days -16 hours'),
            'end_time' => Carbon::parse('-2 days +16 hours'),
            'duration' => 16 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-1 days -12 hours'),
            'end_time' => Carbon::parse('-1 days +12 hours'),
            'duration' => 12 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-15 hours'),
            'end_time' => Carbon::now(),
            'duration' => 15 * 60,
            'tracking' => 0,
        ]);
    }
}
