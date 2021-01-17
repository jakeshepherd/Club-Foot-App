<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BootsTimingTest extends TestCase
{
    use DatabaseMigrations;

    public function test_start_boots_and_bars_timer()
    {
        // we need to be logged in to save the time for the user
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $startTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($startTime);

        $expected = [
            ['start_time' => $startTime]
        ];

        // then post to api to save the start time in the database
        $response = $this->post('/start-tracking');
        $response->assertStatus(201);

        // then get the data back and check it is what we expected (same start hour and minute)
        $actual = BootsAndBarsTime::where('user_id', $user->id)->get('start_time')->toArray();
        $this->assertEqualsWithDelta($expected, $actual, 60);
    }

    public function test_it_adds_multiple_start_times()
    {
        // we need to be logged in to save the time for the user
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $firstStartTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($firstStartTime);

        // then post to api to save the start time in the database
        $response = $this->post('/start-tracking');
        $response->assertStatus(201);

        $secondStartTime = Carbon::now('-2 weeks');
        Carbon::setTestNow($secondStartTime);

        $expected = [
            ['start_time' => $firstStartTime],
            ['start_time' => $secondStartTime],
        ];

        $response = $this->post('/start-tracking');
        $response->assertStatus(201);

        // then get the data back and check it is what we expected (same start hour and minute)
        $actual = BootsAndBarsTime::where('user_id', $user->id)->get('start_time')->toArray();
        $this->assertEqualsWithDelta($expected, $actual, 60);
    }

    public function test_it_stops_boots_and_bars_timer()
    {
        $this->withoutExceptionHandling();

        // we need to be logged in to save the time for the user
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $startTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($startTime);

        $startTimeId = $this->post('/start-tracking')->content();

        $endTime = Carbon::now()->addMinutes('127');
        Carbon::setTestNow($endTime);

        // then post to api to save the start time in the database
        $response = $this->json('POST', '/' . $startTimeId . '/stop-tracking');
        $response->assertStatus(201);

        $expected = [
            [
                'end_time' => $endTime,
                'duration' => '127'
            ],
        ];

        // then get the data back and check it is what we expected (same start hour and minute)
        $actual = BootsAndBarsTime::where('id', $startTimeId)->get(['end_time', 'duration'])->toArray();
        $this->assertEqualsWithDelta($expected, $actual, 0);
    }

    // then want a test about it calculating duration
}
