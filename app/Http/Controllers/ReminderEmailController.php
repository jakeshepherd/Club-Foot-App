<?php

namespace App\Http\Controllers;

use App\Mail\UserInactivity;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReminderEmailController extends Controller
{
    public function queueEmails(): void
    {
        $latestLogins = UserActivity::where('activity_type', 0)
            ->select('user_id', DB::raw('max(created_at) AS created_at'))
            ->orderBy('created_at', 'asc')
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
    }
}
