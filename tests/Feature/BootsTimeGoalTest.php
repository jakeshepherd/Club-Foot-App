<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BootsTimeGoalTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_sets_boots_and_bars_time_goal()
    {
        $this->createUserAndLogin();

        $expected = 15;
        $response = $this->post('/boots-time-goal', [
            'time_goal' => $expected
        ]);
        $response->assertCreated();

        $actual = User::where('id', Auth::id())->get('time_goal')->toArray();

        $this->assertSame($expected*60, $actual[0]['time_goal']);
    }

    public function test_it_sets_goal_with_float()
    {
        $this->createUserAndLogin();

        $expected = 15.5;
        $response = $this->post('/boots-time-goal', [
            'time_goal' => $expected
        ]);
        $response->assertCreated();

        $actual = User::findOrFail(Auth::id())->time_goal;

        $this->assertSame((int) ($expected*60), $actual);
    }

    public function test_it_fails_with_no_post_value()
    {
        $this->createUserAndLogin();

        $response = $this->post('/boots-time-goal', []);
        $response->assertStatus(400);
    }

    public function test_it_gets_time_goal()
    {
        $this->createUserAndLogin();

        $expected = 12;
        $this->post('/boots-time-goal', [
            'time_goal' => $expected
        ]);

        $actual = $this->get('/boots-time-goal');
        $actual->assertOk();

        $this->assertSame($expected*60, (int) $actual->getContent());
    }
}
