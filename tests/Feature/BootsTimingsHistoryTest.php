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

    public function test_get_weekly_average_hours()
    {
        // setup
        $minutesBootsWorn = [840,840,480,900,780,300,660];
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        for ($i = 0; $i<7; $i++) {
            $newRow = new BootsAndBarsTime;
            $newRow->start_time = Carbon::now();
            $newRow->end_time = Carbon::now()->addMinutes($minutesBootsWorn[$i]);
            $newRow->duration = $minutesBootsWorn[$i];
            $newRow->user_id = $user->id;
            $newRow->tracking = false;
            $newRow->save();

            Carbon::now()->subHours($minutesBootsWorn[$i]);
            $startTime->addDay();
            Carbon::setTestNow($startTime);
        }

        // calculate average of the data in here
        $expected = (int) round(array_sum($minutesBootsWorn)/count($minutesBootsWorn), 0);

        // go to endpoint, get averaged data
        $response = $this->get('/get-7-day-average');
        $response->assertOk();
        $actual = (int) $response->getContent();

        // assert equal in minutes
        $this->assertSame($expected, $actual);
    }

    // gonna need some more tests to test how well the last 7 days thing works
}
