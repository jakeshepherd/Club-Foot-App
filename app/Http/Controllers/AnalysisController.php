<?php

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function getSevenDayAverageInMinutes(): JsonResponse
    {
        $average = $this->calculateAverage((new BootsAndBarsTime)->getSevenDayAverage());

        return response()->json($average['average'], $average['status']);
    }

    private function calculateAverage(array $durations): array
    {
        $averages = [];

        // go through and get durations
        foreach ($durations as $duration) {
            // if there are multiple timings on one day, we handle it slightly differently
            if (count($duration) > 1) {
                $dailyTotal = 0;
                foreach ($duration as $subTime) {
                    $dailyTotal += $subTime['duration'];
                }
                $averages[] = $dailyTotal;
            }
            // if there's just one timing for the day then we can just get the duration nicely
            else {
                $averages[] = $duration[0]['duration'];
            }
        }

        // need to check here in case of /0 error.
        if (count($averages) > 0) {
            return [
                'average' => round(array_sum($averages)/count($averages), 0),
                'status' => 200,
            ];
        } else {
            return [
                'average' => 0,
                'status' => 204,
            ];
        }
    }
}
