<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StartTimingTest extends TestCase
{
    use DatabaseMigrations;

    public function test__start_boots_and_bars_timer()
    {
        $this->withoutExceptionHandling();
        // set up
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
        $response = $this->get('/start-tracking');
        $response->assertStatus(200);

        // then get the data back and check it is what we expected (same start hour and minute)
        $actual = BootsAndBarsTime::where('user_id', $user->id)->get('start_time')->toArray();
        $this->assertEqualsWithDelta($expected, $actual, 60);
    }
}
