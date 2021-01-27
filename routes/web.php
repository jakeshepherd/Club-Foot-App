<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\TimingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth'])->name('welcome');

Route::get('/page-2', function () {
    return view('secondpage');
})->middleware(['auth'])->name('Page2');

Route::get('/settings', function () {
    return view('settings');
})->middleware(['auth'])->name('Settings');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/set-boots-time-goal', [UserController::class, 'setTimeGoal'])
        ->name('setTimeGoal');

    Route::post('/start-tracking', [TimingController::class, 'startTracking'])
        ->name('startTracking');

    Route::post('/{id}/stop-tracking', [TimingController::class, 'stopTracking'])
        ->name('stopTracking');

    Route::get('/get-tracking', [TimingController::class, 'getTracking'])
        ->name('getTracking');

    Route::get('/get-7-day-average', [AnalysisController::class, 'getSevenDayAverageInMinutes'])
        ->name('get7DayAverage');

    Route::get('/weekly-adherence', [AnalysisController::class, 'getSevenDayAdherence'])
        ->name('getSevenDayAdherence');
});

require __DIR__.'/auth.php';
