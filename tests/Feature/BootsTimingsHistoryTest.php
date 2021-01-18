<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BootsTimingsHistoryTest extends TestCase
{
    use DatabaseMigrations;

    private function createUserAndLogin() {
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $user;
    }

    public function test_get_weekly_average_minutes()
    {
        // setup
        $hoursBootsWorn = [14,14,8,15,13,5,11];
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        for ($i = 0; $i<7; $i++) {
            $newRow = new BootsAndBarsTime;
            $newRow->start_time = Carbon::now();
            $newRow->end_time = Carbon::now()->addHours($hoursBootsWorn[$i]);
            $newRow->duration = $hoursBootsWorn[$i];
            $newRow->user_id = $user->id;
            $newRow->tracking = false;
            $newRow->save();

            Carbon::now()->subHours($hoursBootsWorn[$i]);
            $startTime->addDay();
            Carbon::setTestNow($startTime);
        }

        // calculate average of the data in here
        $expected = array_sum($hoursBootsWorn)/count($hoursBootsWorn);

        // go to endpoint, get averaged data
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (float) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    // gonna need some more tests to test how well the last 7 days thing works
}
