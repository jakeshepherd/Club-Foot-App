<?php

namespace App\Http\Controllers;

use App\Mail\UserInactivity;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ReminderEmailController extends Controller
{
    public function queueEmails()
    {
        //todo -- change this to left join?
        $ids = UserActivity::where('created_at', '<=', Carbon::now()->subWeek()->toDateTimeString())->get('user_id');
        $users = User::whereIn('id', $ids)->pluck('email');
        foreach ($users as $user) {
            Mail::to($user)->queue(new UserInactivity());
        }
    }
}
