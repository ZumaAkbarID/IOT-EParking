<?php
// Authentication
use App\Http\Controllers\Auth\Login as AuthLogin;
use App\Http\Controllers\Auth\Logout as AuthLogout;
use App\Http\Controllers\Auth\Settings as AuthSettings;
// Guest
use App\Http\Controllers\Guest\Main as GuestMain;
use App\Http\Controllers\Guest\SubmissionBusiness;
// Admin
use App\Http\Controllers\Admin\Dashboard as AdminDashboard;
use App\Http\Controllers\Admin\Submission\All as SubmissionAll;
use App\Http\Controllers\Admin\Submission\Edit as SubmissionEdit;
use App\Http\Controllers\Admin\User\View as AdminUser;
use App\Http\Controllers\Admin\Business\View as AdminBusinessView;
use App\Http\Controllers\Admin\Business\Edit as AdminBusinessEdit;
use App\Http\Controllers\Admin\Machine\View as AdminMachineView;
use App\Http\Controllers\Admin\Machine\Add as AdminMachineAdd;
use App\Http\Controllers\Admin\Machine\Edit as AdminMachineEdit;
use App\Http\Controllers\Admin\Machine\Delete as AdminMachineDelete;
use App\Http\Controllers\Admin\User\Edit as AdminUserEdit;
use App\Http\Controllers\Admin\Report\View as AdminReportView;
// Prngurus
use App\Http\Controllers\Pengurus\Dashboard as PengurusDashboard;
use App\Http\Controllers\Pengurus\Business\Edit as PengurusBusinessEdit;
use App\Http\Controllers\Pengurus\Machine\Edit as PengurusMachineEdit;
use App\Http\Controllers\Pengurus\Machine\View as PengurusMachineView;
use App\Http\Controllers\Pengurus\Machine\Delete as PengurusMachineDelete;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

// Developer Only 
Route::group(['prefix' => 'dev'], function () {
    Route::get('/', function () {
        return view('dev');
    });

    Route::post('/', function (Request $request) {
        if ($request->secret !== '1Kaliaman1!') {
            return redirect()->back()->with('error', 'Secret salah bro');
        }

        if ($request->confirm !== 'ya') {
            return redirect()->back()->with('error', 'Oke kalo ga sadar, kubatalkan');
        }

        if ($request->type == 'symlink') {
            return redirect()->back()->with('success', 'Berhasil dijalankan bro. Ini kodenya : ' . symlink(base_path() . '/storage/app/public', $_SERVER['DOCUMENT_ROOT'] . '/storage'));
        } else if ($request->type == 'migrate-fresh-seed') {
            return redirect()->back()->with('success', 'Berhasil dijalankan bro. Ini kodenya : ' . Artisan::call('migrate:fresh --seed'));
        } else if ($request->type == 'migrate-fresh') {
            return redirect()->back()->with('success', 'Berhasil dijalankan bro. Ini kodenya : ' . Artisan::call('migrate:fresh'));
        } else {
            abort(404);
        }
    });
});

// Guest
Route::get('/', [GuestMain::class, 'index']);
Route::get('/cari/{uuid}', [GuestMain::class, 'index'])->name('Search');
Route::post('/ajax/cari/{cari}', [GuestMain::class, 'search']);
Route::post('/ajax/table/{uuid}/{machine_id}', [GuestMain::class, 'table']);
Route::get('/about-us', function () {
    return view('Guest.about', [
        'title' => 'Tentang Kami | E-Parking'
    ]);
})->name('About.Us');

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
    // Logout
    Route::get('logout', [AuthLogout::class, 'process'])->name('Auth.Logout');
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    // Settings
    Route::get('/', [AuthSettings::class, 'form'])->name('Profile.Settings');
    Route::post('/', [AuthSettings::class, 'process']);
});

// Admin
Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin'], function () {
    // Dashboard
    Route::get('/', [AdminDashboard::class, 'index'])->name('Admin.Dashboard');

    // Submission
    Route::group(['prefix' => 'submission'], function () {
        Route::get('/', [SubmissionAll::class, 'index'])->name('Admin.Submission');
        Route::get('/edit/{uuid}', [SubmissionEdit::class, 'form'])->name('Admin.Submission.Edit');
        Route::post('/edit/{uuid}', [SubmissionEdit::class, 'process']);
    });

    // Business
    Route::group(['prefix' => 'business'], function () {
        Route::get('/', [AdminBusinessView::class, 'all'])->name('Admin.Business.All');
        Route::get('/edit/{uuid}', [AdminBusinessEdit::class, 'form'])->name('Admin.Business.Edit');
        Route::post('/edit/{uuid}', [AdminBusinessEdit::class, 'process']);
    });

    // Machine
    Route::group(['prefix' => 'machine'], function () {
        Route::get('{uuid}', [AdminMachineView::class, 'view'])->name('Admin.Machine.View');
        Route::get('/create/{uuid}', [AdminMachineAdd::class, 'form'])->name('Admin.Machine.Add');
        Route::post('/create/{uuid}', [AdminMachineAdd::class, 'process']);
        Route::get('/edit/{uuid}', [AdminMachineEdit::class, 'form'])->name('Admin.Machine.Edit');
        Route::post('/edit/{uuid}', [AdminMachineEdit::class, 'process']);
        Route::post('/delete/{uuid}', [AdminMachineDelete::class, 'destroy'])->name('Admin.Machine.Delete');
    });

    // Account
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [AdminUser::class, 'all'])->name('Admin.User.All');
        Route::get('/edit/{uuid}', [AdminUserEdit::class, 'form'])->name('Admin.User.Edit');
        Route::post('/edit/{uuid}', [AdminUserEdit::class, 'process']);
    });

    // Report
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', [AdminReportView::class, 'all'])->name('Admin.Report.All');
    });
});

Route::group(['middleware' => ['auth', 'isPengurus'], 'prefix' => 'pengurus'], function () {
    // Dashboard
    Route::get('/', [PengurusDashboard::class, 'index'])->name('Pengurus.Dashboard');

    // Business
    Route::group(['prefix' => 'business'], function () {
        Route::get('', [PengurusBusinessEdit::class, 'form'])->name('Pengurus.Business.Edit');
        Route::post('', [PengurusBusinessEdit::class, 'process']);
    });

    // Machine
    Route::group(['prefix' => 'machine'], function () {
        Route::get('', [PengurusMachineView::class, 'index'])->name('Pengurus.Machine.All');
        Route::get('/edit/{uuid}', [PengurusMachineEdit::class, 'form'])->name('Pengurus.Machine.Edit');
        Route::post('/edit/{uuid}', [PengurusMachineEdit::class, 'process']);

        Route::post('/delete/{uuid}', [PengurusMachineDelete::class, 'destroy'])->name('Pengurus.Machine.Delete');
    });
});
