<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdherencePercentAnalysisTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_get_percent_adherence_for_week()
    {
        $expected = [];

        $user = $this->createUserAndLogin();
        $this->post('/set-boots-time-goal', [
            'time_goal' => '15'
        ]);

        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = true;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(12*60);
        $newRow->duration = 12*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = false;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = false;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(16*60);
        $newRow->duration = 16*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = true;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(18*60);
        $newRow->duration = 18*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = true;

        $response = $this->get('/weekly-adherence');
        $response->assertOk();
        $actual = json_decode($response->content(), true);

        $this->assertSame($expected, $actual);
    }
    public function test_it_works_for_whole_week()
    {
        $expected = [];

        $user = $this->createUserAndLogin();
        $this->post('/set-boots-time-goal', [
            'time_goal' => '15'
        ]);

        $startTime = Carbon::parse('2021-02-02 01:00:00');
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(15*60);
        $expected[$startTime->format('l')] = true;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(12*60);
        $newRow->duration = 12*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(12*60);
        $expected[$startTime->format('l')] = false;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(10*60);
        $expected[$startTime->format('l')] = false;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(16*60);
        $newRow->duration = 16*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(16*60);
        $expected[$startTime->format('l')] = true;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(18*60);
        $newRow->duration = 18*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(18*60);
        $expected[$startTime->format('l')] = true;
        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(18*60);
        $newRow->duration = 18*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(18*60);
        $expected[$startTime->format('l')] = true;
        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(18*60);
        $newRow->duration = 18*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $startTime->subMinutes(18*60);
        $expected[$startTime->format('l')] = true;

        $startTime->addDays(1);
        $response = $this->get('/weekly-adherence');
        $response->assertOk();
        $actual = json_decode($response->content(), true);

        $this->assertSame($expected, $actual);
    }
}
