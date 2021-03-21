<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\QuestionnaireController;
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

//TODO -- add a set time end point and do backend`
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/history', function () {
        return view('history');
    })->name('History');

    Route::get('/more-history', function () {
        return view('more-history');
    })->name('MoreHistory');

    Route::get('/FAQ', function () {
        return view('FAQ');
    })->name('FAQ');

    Route::get('/settings', function () {
        return view('settings');
    })->name('Settings');

    Route::get('/contact', function () {
        return view('contact-details');
    })->name('ContactDetails');

    Route::get('/outcome-questionnaire', function () {
        return view('outcome-questionnaire');
    })->name('OutcomeQuestionnaire');

    Route::get('/outcome-history', function () {
        return view('outcome-history');
    })->name('QuestionnaireHistory');

    Route::get('/dashboard-credit', function () {
        return view('icon-credit');
    })->name('IconCredit');

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

    Route::get('/progress-so-far', [AnalysisController::class, 'getProgressSoFar'])
        ->name('getProgressSoFar');

    Route::post('/timing-history', [AnalysisController::class, 'getHistoryForTimeframe'])
        ->name('getAllHistory');

    Route::post('/roye-outcome-questionnaire', [QuestionnaireController::class, 'setRoyeScoreQuestionnaire'])
        ->name('setRoyeScoreQuestionnaire');

    Route::get('/outcome-results', [QuestionnaireController::class, 'getAllResults'])
        ->name('getAllResults');
});

require __DIR__.'/auth.php';
