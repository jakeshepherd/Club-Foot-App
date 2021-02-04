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

Route::get('/history', function () {
    return view('history');
})->middleware(['auth'])->name('History');

Route::get('/FAQ', function () {
    return view('FAQ');
})->middleware(['auth'])->name('FAQ');

Route::get('/settings', function () {
    return view('settings');
})->middleware(['auth'])->name('Settings');

Route::get('/contact', function () {
    return view('contact-details');
})->middleware(['auth'])->name('ContactDetails');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/boots-time-goal', [UserController::class, 'setTimeGoal'])
        ->name('setTimeGoal');

    Route::get('/boots-time-goal', [UserController::class, 'getTimeGoal'])
        ->name('getTimeGoal');

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

    Route::get('/contact-details', [UserController::class, 'getPhysioDetailsForUser'])
        ->name('getContactDetails');

    Route::post('/contact-details', [UserController::class, 'setPhysioDetailsForUser'])
        ->name('setContactDetails');
});

require __DIR__.'/auth.php';
