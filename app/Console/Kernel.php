<?php

namespace App\Console;

use App\Mail\UserInactivity;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // queue inactivity emails
        $schedule->call(function() {
            $ids = UserActivity::where('created_at', '<=', Carbon::now()->subWeek()->toDateTimeString())->get();
            foreach($ids as $id) {
                $user = $id->user;
                if ($user->activity_reminded == false) {
                    Mail::to($user->email)->queue(new UserInactivity());

                    // set activity reminded so that we don't send loads of emails
                    $user->activity_reminded = true;
                    $user->save();
                }
            }
        })->everyMinute();

        // send emails
        $schedule->command('queue:work')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
