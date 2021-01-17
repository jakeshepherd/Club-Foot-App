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
        $bootsAndBarsRow->save();

        return response()->json($bootsAndBarsRow->id, 201);
    }
}
