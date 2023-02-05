<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/esp/{ip}/{machine_id}/{slots}', function ($ip, $machine_id, $slots) {
    Log::info("IP : {$ip}\nMachine ID : {$machine_id}\nSlots : {$slots}");
    return response("IP : {$ip}\nMachine ID : {$machine_id}\nSlots : {$slots}", 200);
});