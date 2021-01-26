<?php

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function calculateSevenDayAverageInMinutes(): JsonResponse
    {
        $durations = (new BootsAndBarsTime)->getSevenDayAverage();
        $averages = [];

        foreach ($durations as $duration) {
            $averages[] = $duration['duration'];
        }
        if (count($averages) > 0) {
            return response()->json(round(array_sum($averages)/count($averages), 0), 200);
        } else {
            return response()->json(0, 204);
        }
    }
}
