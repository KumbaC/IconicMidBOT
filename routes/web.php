<?php

use App\Http\Controllers\BotManController;
use App\Models\Position;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingTimeController;

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
});

Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('positions', PositionController::class,)->names('admin.positions');
Route::resource('users', UserController::class,)->names('admin.users');
Route::resource('working-time', WorkingTimeController::class,)->names('admin.working');
