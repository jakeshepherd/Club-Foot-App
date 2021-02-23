<?php

namespace App\Http\Controllers;

use App\Mail\UserInactivity;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ReminderEmailController extends Controller
{
    public function queueEmails(): void
    {
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
    }
}
