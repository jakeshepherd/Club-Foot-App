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
    protected $fillable = [
        'start_time',
    ];

    public function getSevenDayAverage(): array
    {
        return BootsAndBarsTime::where('user_id', Auth::id())
            ->whereBetween('end_time', [Carbon::parse('-7 days'), Carbon::now()])
            ->get(['end_time', 'duration'])->toArray();
    }
}
