<?php
// Authentication
use App\Http\Controllers\Auth\Login as AuthLogin;
// Guest
use App\Http\Controllers\Guest\Main as GuestMain;

use Illuminate\Support\Facades\Log;
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

// Guest
Route::get('/', [GuestMain::class, 'index']);

// Authentication
Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    // Login
    Route::get('login', [AuthLogin::class, 'form'])->name('Auth.Login');
    Route::post('login', [AuthLogin::class, 'process']);
});
