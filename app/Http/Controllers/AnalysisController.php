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
    private $bootsAndBarsTime;

    public function __construct()
    {
        $this->bootsAndBarsTime = new BootsAndBarsTime();
    }

    public function getHistoryForTimeframe(Request $request): JsonResponse
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $allTimes = $this->bootsAndBarsTime->getTimeWithinTimeframe(
            $startDate,
            $endDate
        );

        $data = $this->formatForGraph($allTimes);
        $data['start_date'] = $startDate->format('d-m-Y');
        $data['end_date'] = $endDate->format('d-m-Y');

        if (empty($data)) {
            return response()->json($data, 204);
        }
        return response()->json($data);
    }

    public function getSevenDayAverageInMinutes(): JsonResponse
    {
        $average = $this->calculateAverage(
            $this->bootsAndBarsTime->getSevenDayTimes()
        );

        return response()->json($average['average'], $average['status']);
    }

    public function getSevenDayAdherence(): JsonResponse
    {
        $timeGoal = User::findOrFail(Auth::id())->time_goal;

        if (is_null($timeGoal)) {
            return response()->json('⏰ Please set a time goal', 404);
        }

        $data = $this->formatWeeklyAdherenceData(
            $this->bootsAndBarsTime->getSevenDayTimes(),
            $timeGoal
        );

        return response()->json($data['data'], $data['status']);
    }

    public function getProgressSoFar(): JsonResponse
    {
        $data = $this->formatForGraph(
            $this->bootsAndBarsTime->getSevenDayTimes(),
        );

        if (empty($data)) {
            return response()->json($data, 204);
        }

        // get how long FAB worn for
        $oldestRecord = BootsAndBarsTime::where('user_id', Auth::id())
            ->oldest()->pluck('end_time')->first();
        $diffInWeeks = Carbon::parse($oldestRecord)->diffInWeeks(Carbon::now());

        // weeks the boots have been worn for
        $data['boots_worn_for'] = $diffInWeeks == 0 ? 1 : $diffInWeeks;
        $data['total_average'] = (array_sum($data['hours'])/count($data['days']))*60;

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
                    if ($subTime['duration'] !== 0) {
                        $dailyTotal += $subTime['duration'];
                    }
                }
                $weeklyAdherence['days'][] = Carbon::parse($duration[0]['end_time'])->format('l');
                $weeklyAdherence['hours'][] = round($dailyTotal/60, 1);
            }
            // if there's just one timing for the day then we can just get the duration nicely
            else {
                $subDuration = $duration[0];
                $weeklyAdherence['days'][] = Carbon::parse($subDuration['end_time'])->format('l');
                $weeklyAdherence['hours'][] = round($subDuration['duration']/60, 1);
            }
        }

        return $weeklyAdherence;
    }

    private function formatWeeklyAdherenceData(array $durations, int $timeGoal): array
    {
        $dailyTimings = [];
        $weeklyAdherence = [];

        $start = Carbon::now()->subDays(7);
        foreach (range(0, 6) as $day) {
            $weeklyAdherence[$start->addDay()->format('l')] = null;
        }

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
