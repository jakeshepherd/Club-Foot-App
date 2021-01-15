<?php

use App\Http\Controllers\TimingController;
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

Route::get('/start-tracking', [TimingController::class, 'startTracking'])
    ->middleware(['auth'])->name('startTracking');

require __DIR__.'/auth.php';
