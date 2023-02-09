<?php
// Authentication
use App\Http\Controllers\Auth\Login as AuthLogin;
use App\Http\Controllers\Auth\Logout as AuthLogout;
// Guest
use App\Http\Controllers\Guest\Main as GuestMain;
use App\Http\Controllers\Guest\SubmissionBusiness;
// Admin
use App\Http\Controllers\Admin\Dashboard as AdminDashboard;

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
Route::get('/cari/{uuid}', [GuestMain::class, 'index'])->name('Search');
Route::post('/ajax/cari/{cari}', [GuestMain::class, 'search']);
Route::post('/ajax/table/{uuid}/{machine_id}', [GuestMain::class, 'table']);

// Authentication
Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    // Login
    Route::get('login', [AuthLogin::class, 'form'])->name('Auth.Login');
    Route::post('login', [AuthLogin::class, 'process']);
});

// Guest
Route::group(['middleware' => 'guest'], function () {
    Route::get('submission', [SubmissionBusiness::class, 'form'])->name('SubmissionBusiness');
    Route::post('submission', [SubmissionBusiness::class, 'process']);
});

Route::group(['prefix' => 'auth', 'middleware' => 'auth'], function () {
    Route::get('logout', [AuthLogout::class, 'process'])->name('Auth.Logout');
});

// Admin
Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('Admin.Dashboard');
});