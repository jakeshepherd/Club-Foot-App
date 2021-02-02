<?php

namespace App\Http\Controllers;

use App\Models\PhysioContactDetails;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function setTimeGoal(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'time_goal' => 'required'
            ]);
        } catch (ValidationException $e) {
            Log::error('time_goal not specified in POST. Please try again.');
            return response()->json('time_goal not specified in POST. Please try again.', 400);
        }

        $user = User::findOrFail(Auth::id());
        $user->time_goal = request('time_goal')*60;
        $user->save();

        return response()->json($user->time_goal, 201);
    }

    public function getTimeGoal(): JsonResponse
    {
        return response()->json(User::findOrFail(Auth::id())->time_goal);
    }

    public function getPhysioDetailsForUser()
    {
        $results = PhysioContactDetails::findOrFail(Auth::id())->get(['name', 'email', 'phone_number'])
            ->toArray();

        return response()->json($results[0]);
    }
}
