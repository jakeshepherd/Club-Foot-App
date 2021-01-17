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

    private function createUser() {
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $user;
    }

    public function test_start_boots_and_bars_timer()
    {
        // we need to be logged in to save the time for the user
        $user = $this->createUser();

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

    public function test_it_stops_boots_and_bars_timer()
    {
        // we need to be logged in to save the time for the user
        $user = $this->createUser();

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

    public function test_it_doesnt_allow_stopping_with_no_start() {
        $this->createUser();
        $startTimeId = 1;

        $response = $this->json('POST', '/' . $startTimeId . '/stop-tracking');
        $response->assertNotFound();
        $this->assertDatabaseCount('boots_and_bars_times', 0);
    }

    public function test_it_can_find_timings_without_end_time() {
        // we need to be logged in to save the time for the user
        $this->createUser();

        $startTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($startTime);

        // then post to api to save the start time in the database
        $response = $this->post('/start-tracking');
        $response->assertCreated();
        $startTimeId = $response->content();

        $response = $this->get('/get-tracking');
        $response->assertOk();
        $actual = $response->getContent();

        $expected = [
            'id' => (int) $startTimeId,
            'tracking' => true
        ];

        $this->assertSame(json_encode($expected), $actual);
    }

    public function test_it_works_without_start_time() {
        // we need to be logged in to save the time for the user
        $this->createUser();

        // then post to api to save the start time in the database
        $response = $this->get('/get-tracking');
        $response->assertOk();
        $actual = $response->getContent();

        $expected = [
            'id' => 0,
            'tracking' => false,
        ];

        $this->assertSame(json_encode($expected), $actual);
    }

    public function test_it_can_handle_multiple_durations() {
        // we need to be logged in to save the time for the user
        $this->createUser();

        $startTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($startTime);

        // then post to api to save the start time in the database
        $response = $this->post('/start-tracking');
        $response->assertCreated();
        $startTimeId = $response->getContent();

        // then post to api to save the start time in the database
        $response = $this->json('POST', '/' . $startTimeId . '/stop-tracking');
        $response->assertStatus(201);

        $response = $this->post('/start-tracking');
        $response->assertCreated();
        $startTimeId = $response->getContent();

        $response = $this->get('/get-tracking');
        $response->assertOk();
        $actual = $response->getContent();

        $expected = [
            'id' => (int) $startTimeId,
            'tracking' => true
        ];

        $this->assertSame(json_encode($expected), $actual);
    }

    public function test_you_cant_start_more_than_once_tracking() {
        // we need to be logged in to save the time for the user
        $this->createUser();

        $startTime = Carbon::now()->format('Y-m-d H:m:s');
        Carbon::setTestNow($startTime);

        // then post to api to save the start time in the database
        $response = $this->post('/start-tracking');
        $response->assertCreated();

        $response = $this->post('/start-tracking');
        $responseContent = json_decode($response->getContent(), true);
        $this->assertSame(['error' => 'User already tracking boots and bars time.'], $responseContent);
        $response->assertStatus(409);


        $this->assertDatabaseCount('boots_and_bars_times', 1);
    }
}
