<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        }

        $user = User::findOrFail(Auth::id());
        $user->time_goal = request('time_goal');
        $user->save();

        return response()->json($user->time_goal, 201);
    }
}
