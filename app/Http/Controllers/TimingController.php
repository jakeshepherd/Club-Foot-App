<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimingController extends Controller
{
    public function startTracking() {
        $brand = new BootsAndBarsTime();
        $brand->user_id = Auth::id();
        $brand->start_time = Carbon::now();
        $brand->save();
    }
}
