<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BootsTimingsHistoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_weekly_average_hours()
    {
        // setup
        $minutesBootsWorn = [840,840,480];
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        for ($i = 0; $i<sizeof($minutesBootsWorn); $i++) {
            $newRow = new BootsAndBarsTime;
            $newRow->start_time = $startTime;
            $newRow->end_time = $startTime->addMinutes($minutesBootsWorn[$i]);
            $newRow->duration = $minutesBootsWorn[$i];
            $newRow->user_id = $user->id;
            $newRow->tracking = false;
            $newRow->save();

            $startTime->subMinutes($minutesBootsWorn[$i]);
            $startTime->addDays(2);
        }

        // calculate average of the data in here
        $expected = (int) round(array_sum($minutesBootsWorn)/count($minutesBootsWorn));

        // go to endpoint, get averaged data
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    public function test_it_doesnt_include_8_days_before() {
        // setup
        $expected = 840;
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes($expected);
        $newRow->duration = $expected;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = Carbon::parse('-8 days');
        $newRow->end_time = Carbon::parse('-8 days')->addMinutes(900);
        $newRow->duration = 900;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        // go to endpoint, get averaged data
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    public function test_ignores_less_than_10_minutes() {
        // setup
        $minutesBootsWorn = [5,840,480];
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        for ($i = 0; $i<3; $i++) {
            $newRow = new BootsAndBarsTime;
            $newRow->start_time = $startTime;
            $newRow->end_time = $startTime->addMinutes($minutesBootsWorn[$i]);
            $newRow->duration = $minutesBootsWorn[$i];
            $newRow->user_id = $user->id;
            $newRow->tracking = false;
            $newRow->save();

            $startTime->subMinutes($minutesBootsWorn[$i]);
            $startTime->addDays(2);
        }

        // calculate average of the data in here
        $expected = 0;
        for($i = 1; $i<3; $i++) {
            $expected += $minutesBootsWorn[$i];
        }

        $expected = (int) round($expected/2);

        // go to endpoint, get averaged data
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    public function test_it_works_with_no_times() {
        // setup
        $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // calculate average of the data in here
        $expected = 0;

        $response = $this->get('/get-7-day-average');
        $response->assertNoContent();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    public function test_it_works_with_times_on_same_day_on_multiple_days() {
        $this->withoutExceptionHandling();
        // setup
        $user = $this->createUserAndLogin();
        $startTime = Carbon::parse('01/01/21 12:00:00');
        Carbon::setTestNow($startTime);

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(120);
        $newRow->duration = 120;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(120);
        $newRow->duration = 120;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = Carbon::parse('+1 day');
        $newRow->end_time = Carbon::parse('+1 day')->addMinutes(180);
        $newRow->duration = 180;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $expected = ((120+120) + 180)/2;

        // go to endpoint, get averaged data
        $startTime->addDays(2);
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }
}
