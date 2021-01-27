<?php

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function getSevenDayAverageInMinutes(): JsonResponse
    {
        $average = $this->calculateAverage((new BootsAndBarsTime)->getSevenDayTimes());

        return response()->json($average['average'], $average['status']);
    }

    public function getSevenDayAdherence(): JsonResponse
    {
        $dailyTimings = [];
        $durations = (new BootsAndBarsTime)->getSevenDayTimes();
        $timeGoal = (User::findOrFail(Auth::id())->time_goal);

        // go through and get durations
        foreach ($durations as $duration) {
            // if there are multiple timings on one day, we handle it slightly differently
            if (count($duration) > 1) {
                $dailyTotal = 0;
                foreach ($duration as $subTime) {
                    $dailyTotal += $subTime['duration'];
                }
                $dailyTimings[$duration[0]['end_time']] = $dailyTotal;
            }
            // if there's just one timing for the day then we can just get the duration nicely
            else {
                $dailyTimings[$duration[0]['end_time']] = $duration[0]['duration'];
            }
        }
        $weeklyAdherence = [];
        foreach ($dailyTimings as $date => $duration) {
            $date = Carbon::parse($date)->format('l');
            if ($duration >= $timeGoal) {
                 $weeklyAdherence[$date] = true;
            } else {
                $weeklyAdherence[$date] = false;
            }
        }

        return response()->json($weeklyAdherence, 200);
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
