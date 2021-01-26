<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BootsAndBarsTime extends Model
{
    use HasFactory;

    protected $table = 'boots_and_bars_times';

    public function getSevenDayAverage(): array
    {
        return array_values(
            BootsAndBarsTime::where('user_id', Auth::id())
            ->whereBetween('end_time', [Carbon::parse('-7 days'), Carbon::now()])
            ->where('duration', '>=', '10')
            ->get(['end_time', 'duration'])
            ->groupBy(function ($val) {
                return Carbon::parse($val->end_time)->format('d');
            })
            ->toArray()
        );
    }
}
