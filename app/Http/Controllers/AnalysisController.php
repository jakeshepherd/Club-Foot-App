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
            $averages[] = (float) $duration['duration'];
        }

        return response()->json(array_sum($averages)/count($averages), 200);
    }
}
