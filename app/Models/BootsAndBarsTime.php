<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootsAndBarsTime extends Model
{
    use HasFactory;

    protected $table = 'boots_and_bars_times';
    protected $fillable = [
        'start_time',
    ];
}
