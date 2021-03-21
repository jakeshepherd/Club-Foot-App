<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TimingController extends Controller
{
    public function startTracking(): JsonResponse
    {
        // find if the user has something that is being tracked right now, if it is then dont allow anymore tracking
        $existingRecord = BootsAndBarsTime::where([
            ['user_id', Auth::id()],
            ['tracking', true],
        ])->get();

        if ($existingRecord->isNotEmpty()) {
            return response()->json([
                'error' => 'User already tracking boots and bars time.',
            ], 409);
        }

        $bootsAndBarsRow = new BootsAndBarsTime();
        $bootsAndBarsRow->user_id = Auth::id();
        $bootsAndBarsRow->start_time = Carbon::now();
        $bootsAndBarsRow->tracking = true;
        $bootsAndBarsRow->save();

        return response()->json($bootsAndBarsRow->id, 201);
    }

    public function stopTracking(int $timeId): JsonResponse
    {
        $time = BootsAndBarsTime::findOrFail($timeId);
        $time->end_time = Carbon::now();
        $time->duration = (Carbon::parse($time->start_time))->diffInMinutes($time->end_time);
        $time->tracking = false;
        $time->save();

        return response()->json($time->duration, 201);
    }

    public function getTracking(): JsonResponse
    {
        $time = BootsAndBarsTime::where([
            ['user_id', Auth::id()],
            ['tracking', true],
        ])->get();

        if ($time->isEmpty()) {
            return response()->json([
                'id' => 0,
                'tracking' => false,
            ], 200);
        } else {
            return response()->json([
                'id' => $time[0]->id,
                'tracking' => (bool) $time[0]->tracking,
            ]);
        }
    }

    public function setTime(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'end_time' => 'required',
                'duration' => 'required'
            ]);
        } catch (ValidationException $e) {
            Log::error('end_time and duration must be specified in POST. Please try again.');
            return response()->json('Please fill in all the details', 400);
        }

        $end_time = Carbon::parse(request('end_time'));

        BootsAndBarsTime::create([
            'user_id' => Auth::id(),
            'start_time' => $end_time,
            'end_time' => $end_time,
            'duration' => request('duration'),
            'tracking' => 0
        ]);

        return response()->json('Success', 201);
    }
}
