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

    public function getSevenDayTimes(): array
    {
        return array_values(
            BootsAndBarsTime::where('user_id', Auth::id())
            ->whereBetween('end_time', [Carbon::parse('-7 days'), Carbon::now()])
            ->where('duration', '>=', '10')
            ->get(['end_time', 'duration'])
            ->groupBy(function ($element) {
                return Carbon::parse($element->end_time)->format('d');
            })
            ->toArray()
        );
    }
}
