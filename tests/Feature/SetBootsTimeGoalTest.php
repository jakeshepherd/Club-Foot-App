<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SetBootsTimeGoalTest extends TestCase
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

    public function test_it_sets_boots_and_bars_time_goal()
    {
        $this->withoutExceptionHandling();
        $this->createUserAndLogin();

        $expected = '15';
        $response = $this->post('/set-boots-time-goal', [
            'time_goal' => $expected
        ]);
        $response->assertCreated();

        $actual = User::where('id', Auth::id())->get('time_goal')->toArray();

        $this->assertSame($expected, $actual[0]['time_goal']);
    }
}
