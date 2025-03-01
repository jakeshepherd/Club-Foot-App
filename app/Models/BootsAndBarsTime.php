<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BootsAndBarsTime extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'duration' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'end_time',
        'start_time',
        'duration',
        'tracking',
    ];

    public function getTimeWithinTimeframe(Carbon $startDate, Carbon $endDate): array
    {
        return array_values(
            BootsAndBarsTime::where('user_id', Auth::id())
                ->whereBetween('end_time', [$startDate, $endDate])
                ->where('duration', '>=', '10')
                ->get(['end_time', 'duration'])
                ->groupBy(function ($element) {
                    return Carbon::parse($element->end_time)->format('d');
                })
                ->toArray()
        );
    }

    public function getSevenDayTimes(): array
    {
        return array_values(
            BootsAndBarsTime::where('user_id', Auth::id())
            ->whereBetween('end_time', [Carbon::parse('-7 days'), Carbon::now()])
            ->where('duration', '>=', '10')
            ->orderBy('end_time', 'ASC')
            ->get(['end_time', 'duration'])
            ->groupBy(function ($element) {
                return Carbon::parse($element->end_time)->format('d');
            })
            ->toArray()
        );
    }
}
