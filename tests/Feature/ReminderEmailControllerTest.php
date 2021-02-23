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

    public function test_it_only_sends_email_once_for_multiple_logins()
    {
        //setup
        $testTime = Carbon::parse('-3 weeks');
        Carbon::setTestNow($testTime);
        Mail::fake();

        //act
        $user = $this->createUserAndLogin();
        $this->post('/logout');
        $testTime->addWeek();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->post('/logout');

        (new ReminderEmailController())->queueEmails();

        //assert
        Mail::assertQueued(UserInactivity::class, 1);
    }

    public function test_it_only_sends_email_once_if_user_still_has_not_logged_in()
    {
        //setup
        $testTime = Carbon::parse('-5 weeks');
        Carbon::setTestNow($testTime);
        Mail::fake();

        //act
        $user = $this->createUserAndLogin();
        $this->post('/logout');
        $testTime->addWeek();
        (new ReminderEmailController())->queueEmails();

        $testTime->addWeek();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->post('/logout');
        $testTime->addWeek();
        (new ReminderEmailController())->queueEmails();

        $testTime->addWeek();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->post('/logout');
        $testTime->addWeek();
        (new ReminderEmailController())->queueEmails();

        //assert
        Mail::assertQueued(UserInactivity::class, 1);
    }
}
