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

    public function getPhysioDetailsForUser(): JsonResponse
    {
        $results = PhysioContactDetails::where('user_id', Auth::id())->get(['name', 'email', 'phone_number'])
            ->toArray();

        return response()->json($results[0]);
    }

    public function setPhysioDetailsForUser(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
            ]);
        } catch (ValidationException $e) {
            Log::error('name, email or phone_number not specified in POST. Please try again.');
            return response()->json('name, email or phone_number not specified in POST. Please try again.', 400);
        }

        $record = PhysioContactDetails::where('user_id', Auth::id())->first();

        if ($record->count() !== 0) {
            $record->name = request('name');
            $record->email = request('email');
            $record->phone_number = request('phone_number');
            $record->save();

            return response()->json(true);
        } else {
            PhysioContactDetails::create([
                'user_id' => Auth::id(),
                'name' => request('name'),
                'email' => request('email'),
                'phone_number' => request('phone_number'),
            ]);

            return response()->json(true, 201);
        }
    }
}
