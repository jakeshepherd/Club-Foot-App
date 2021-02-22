<?php

namespace Tests\Feature;

use App\Http\Controllers\ReminderEmailController;
use App\Mail\UserInactivity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReminderEmailControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_queues_emails()
    {
        //setup
        $testTime = Carbon::parse('-2 weeks');
        Carbon::setTestNow($testTime);
        Mail::fake();

        //act
        $this->createUserAndLogin();
        $this->post('/logout');
        $testTime->addWeeks(2);

        (new ReminderEmailController())->queueEmails();

        //assert
        Mail::assertQueued(UserInactivity::class);
    }
}
