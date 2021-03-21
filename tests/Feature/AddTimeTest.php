<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AddTimeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_adds_retrospective_time()
    {
        $this->withoutExceptionHandling();
        Carbon::setTestNow(Carbon::now());
        $user = $this->createUserAndLogin();

        $expected = [
            'end_time' => Carbon::now(),
            'duration' => 780
        ];
        $response = $this->post('/set-time', $expected);
        $response->assertStatus(201);

        $actual = BootsAndBarsTime::findOrFail($user->id);

        $this->assertEqualsWithDelta($expected['end_time'], $actual['end_time'], 5);
        $this->assertSame($expected['duration'], $actual['duration']);
    }
}
