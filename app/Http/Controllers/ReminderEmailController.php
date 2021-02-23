<?php

namespace App\Http\Controllers;

use App\Mail\UserInactivity;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderEmailController extends Controller
{
    public function queueEmails(): int
    {
        Log::error('I AM HERE');
        $ids = UserActivity::where('created_at', '<=', Carbon::now()->subWeek()->toDateTimeString())->get();
        Log::error($ids);
        foreach($ids as $id) {
            $user = $id->user;
            Log::error($user);
            Log::error($user->activity_reminded);
            if ($user->activity_reminded == false) {
                Mail::to($user->email)->queue(new UserInactivity());

                // set activity reminded so that we don't send loads of emails
                $user->activity_reminded = true;
                $user->save();
            }
        }
        return 1;
    }
}
