<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TimingController extends Controller
{
    public function startTracking(): JsonResponse
    {
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
            ['tracking', '1'],
        ])->firstOrFail();

        return response()->json($time->id, 200);
    }
}
