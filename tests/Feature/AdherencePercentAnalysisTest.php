<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdherencePercentAnalysisTest extends TestCase
{
    use DatabaseMigrations;

    private function populateExpectedArray(): array
    {
        $expected = [];
        $start = Carbon::now()->subDays(7);
        foreach (range(0, 6) as $day) {
            $expected[$start->addDay()->format('l')] = null;
        }

        return $expected;
    }

    public function test_it_can_get_percent_adherence_for_week()
    {
        $user = $this->createUserAndLogin();
        $this->post('/boots-time-goal', [
            'time_goal' => '15'
        ]);

        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        $expected = $this->populateExpectedArray();

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
        $user = $this->createUserAndLogin();
        $this->post('/boots-time-goal', [
            'time_goal' => '15'
        ]);

        $startTime = Carbon::parse('2021-02-02 01:00:00');
        Carbon::setTestNow($startTime);

        $expected = $this->populateExpectedArray();

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

        $startTime->addDay();
        $response = $this->get('/weekly-adherence');
        $response->assertOk();
        $actual = json_decode($response->content(), true);

        $this->assertSame($expected, $actual);
    }
    public function test_it_works_with_no_data() {
        $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        $this->post('/boots-time-goal', [
            'time_goal' => '15'
        ]);

        $response = $this->get('/weekly-adherence');
        $response->assertStatus(200);
        $actual = (int) $response->content();

        $this->assertSame(0, $actual);
    }
    public function test_it_works_with_multiple_times_on_same_day() {
        $this->withoutExceptionHandling();

        $user = $this->createUserAndLogin();
        $this->post('/boots-time-goal', [
            'time_goal' => '15'
        ]);

        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        $expected = $this->populateExpectedArray();

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = false;

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(6*60);
        $newRow->duration = 6*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = true;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected[$startTime->format('l')] = false;

        $response = $this->get('/weekly-adherence');
        $response->assertOk();
        $actual = json_decode($response->content(), true);

        $this->assertEquals($expected, $actual);
    }
}
