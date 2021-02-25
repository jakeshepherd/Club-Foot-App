<?php

namespace Database\Seeders;

use App\Models\BootsAndBarsTime;
use App\Models\PhysioContactDetails;
use App\Models\OutcomeQuestionnaireResult;
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
             'name' => 'User',
             'email' => 'user@gmail.com',
             'password' => '$2y$10$mJYZB0nTFwGfBT6Z61YQiO2YiP3YZpZaU6wpMUKBor1UK0KfwMLrm',
             'time_goal' => 15*60
         ]);
         BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-14 days -16 hours'),
            'end_time' => Carbon::parse('-14 days +16 hours'),
            'duration' => 16 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-13 days -0.5 hours'),
            'end_time' => Carbon::parse('-13 days +0.5 hours'),
            'duration' => 0.5 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-12 days -8 hours'),
            'end_time' => Carbon::parse('-12 days +8 hours'),
            'duration' => 8 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-11 days -19 hours'),
            'end_time' => Carbon::parse('-11 days +19 hours'),
            'duration' => 19 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-10 days -11 hours'),
            'end_time' => Carbon::parse('-10 days +11 hours'),
            'duration' => 11 * 60,
            'tracking' => 0,
        ]);
         BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-9 days -10 hours'),
            'end_time' => Carbon::parse('-9 days +10 hours'),
            'duration' => 10 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-8 days -16 hours'),
            'end_time' => Carbon::parse('-8 days +16 hours'),
            'duration' => 16 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-7 days -17 hours'),
            'end_time' => Carbon::parse('-7 days +17 hours'),
            'duration' => 17 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-6 days -16 hours'),
            'end_time' => Carbon::parse('-6 days +16 hours'),
            'duration' => 16 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-5 days -15 hours'),
            'end_time' => Carbon::parse('-5 days +15 hours'),
            'duration' => 15 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-4 days -14 hours'),
            'end_time' => Carbon::parse('-4 days +16 hours'),
            'duration' => 14 * 60,
            'tracking' => 0,
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
            'start_time' => Carbon::parse('-1 days -2 hours'),
            'end_time' => Carbon::parse('-1 days +2 hours'),
            'duration' => 2 * 60,
            'tracking' => 0,
        ]);
        BootsAndBarsTime::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('-15 hours'),
            'end_time' => Carbon::now(),
            'duration' => 15 * 60,
            'tracking' => 0,
        ]);
        OutcomeQuestionnaireResult::create([
            'user_id' => $user->id,
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode([2,1,2,3,1,1,4,1,2,1]),
            'created_at'=> Carbon::parse('-3 days')
        ]);
        OutcomeQuestionnaireResult::create([
            'user_id' => $user->id,
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode([2,1,2,3,1,1,4,1,2,1]),
            'created_at'=> Carbon::parse('-2 days')
        ]);
        OutcomeQuestionnaireResult::create([
            'user_id' => $user->id,
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode([1,1,1,1,1,1,1,1,1,1]),
            'created_at'=> Carbon::parse('-1 day')
        ]);
        PhysioContactDetails::create([
            'user_id' => $user->id,
            'name' => 'Example Name',
            'email' => 'email@example.com',
            'phone_number' => '0123456789',
        ]);
    }
}
