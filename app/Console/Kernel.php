<?php

namespace App\Console;

use App\Mail\UserInactivity;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
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
            $latestLogins = UserActivity::where('activity_type',0)
                ->select('user_id',DB::raw('max(created_at) AS created_at'))
                ->orderBy('created_at','asc')
                ->groupBy('user_id')
                ->get('created_at', 'user_id');
            foreach ($latestLogins as $latestLogin) {
                $user = $latestLogin->user;
                if ($latestLogin->created_at < Carbon::now()->subWeek() && !$user->activity_reminded) {
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
