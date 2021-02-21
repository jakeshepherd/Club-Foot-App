<?php

namespace Tests\Feature;

use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogsUserActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_logs_on_login()
    {
        $time = Carbon::now();
        Carbon::setTestNow($time);

        $user = $this->createUserAndLogin();
        $this->post('/logout');

        $time->addDay();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $actual = UserActivity::where([
            'user_id' => $user->id,
            'activity_type' => 0,
        ])->latest()->first('created_at');

        $this->assertEqualsWithDelta($time, $actual->created_at, 5);
        $this->assertDatabaseCount('user_activity', 2);
    }

    public function test_it_logs_on_login_with_different_users()
    {
        $time = Carbon::now();
        Carbon::setTestNow($time);

        $this->createUserAndLogin();
        $this->post('/logout');

        $time->addDay();
        $user = $this->createUserAndLogin();

        $actual = UserActivity::where([
            'user_id' => $user->id,
            'activity_type' => 0,
        ])->latest()->get('user_id');

        $this->assertCount(1, $actual);
        $this->assertEquals($user->id, $actual[0]->user_id);
    }
}
