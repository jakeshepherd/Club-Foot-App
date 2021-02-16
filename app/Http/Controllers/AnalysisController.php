<?php

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function getSevenDayAverageInMinutes(): JsonResponse
    {
        $average = $this->calculateAverage(
            (new BootsAndBarsTime)->getSevenDayTimes()
        );

        return response()->json($average['average'], $average['status']);
    }

    public function getSevenDayAdherence(): JsonResponse
    {
        $data = $this->formatWeeklyAdherenceData(
            (new BootsAndBarsTime)->getSevenDayTimes(),
            User::findOrFail(Auth::id())->time_goal
        );

        return response()->json($data['data'], $data['status']);
    }

    public function getProgressSoFar(): JsonResponse
    {
        $data = $this->formatForGraph(
            (new BootsAndBarsTime)->getSevenDayTimes(),
        );

        if (empty($data)) {
            return response()->json($data, 204);
        }

        // get how long FAB worn for
        $oldestRecord = BootsAndBarsTime::where('user_id', Auth::id())
            ->oldest()->pluck('end_time')->first();

        $data['boots_worn_for'] = Carbon::parse($oldestRecord)->diffInWeeks(Carbon::now());

        return response()->json($data);
    }

    private function formatForGraph(array $durations): array
    {
        $weeklyAdherence = [];
        foreach ($durations as $duration) {
            // if there are multiple timings on one day, we handle it slightly differently
            if (count($duration) > 1) {
                $dailyTotal = 0;
                foreach ($duration as $subTime) {
                    $dailyTotal += $subTime['duration'];
                }
                $weeklyAdherence['days'][] = Carbon::parse($duration[0]['end_time'])->format('l');
                $weeklyAdherence['hours'][] = $dailyTotal/60;
            }
            // if there's just one timing for the day then we can just get the duration nicely
            else {
                $subDuration = $duration[0];
                $weeklyAdherence['days'][] = Carbon::parse($subDuration['end_time'])->format('l');
                $weeklyAdherence['hours'][] = $subDuration['duration']/60;
            }
        }

        return $weeklyAdherence;
    }

    private function formatWeeklyAdherenceData(array $durations, int $timeGoal): array
    {
        $dailyTimings = [];
        $weeklyAdherence = [];
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

        foreach ($dailyTimings as $date => $duration) {
            $weeklyAdherence[Carbon::parse($date)->format('l')] = $duration >= $timeGoal;
        }

        if (empty($weeklyAdherence)) {
            return [
                'data' => 0,
                'status' => 204,
            ];
        }
        return [
            'data' => $weeklyAdherence,
            'status' => 200,
        ];
    }

    private function calculateAverage(array $durations): array
    {
        $averages = [];
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

        // need to check here in case of divide by 0 error.
        if (count($averages) > 0) {
            return [
                'average' => round(array_sum($averages)/count($averages)),
                'status' => 200,
            ];
        }
        return [
            'average' => 0,
            'status' => 204,
        ];
    }
}
