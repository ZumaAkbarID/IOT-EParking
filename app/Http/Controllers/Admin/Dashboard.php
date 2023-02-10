<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessSubmission;
use App\Models\Trafic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        $singleTrafics = Trafic::selectRaw("business_uuid, count(business_uuid) as count")
            ->groupBy('business_uuid')
            ->orderBy('count', 'DESC')
            ->limit('3')
            ->get();

        $trafics = Trafic::select(
            DB::raw('COUNT(type) as countType'),
            DB::raw('type'),
            DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            DB::raw("EXTRACT(MONTH FROM `created_at`) as mon")
        )
            ->whereBetween('created_at', [date('Y') . '-01-01 00:00:01', date('Y') . '-12-31 23:59:59'])
            ->groupBy('type', 'mon', 'year')->get();

        $traficMonthly = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($trafics as $trf) {
            if ($trf->type == 'parent') {
                $traficMonthly[$trf->mon - 1] = $trf->countType;
            }
        }

        // Trafic
        $trafic = [];
        $trafic['e-parking'] = count(Trafic::where('type', 'parent')->get());
        $trafic['monthly'] = $traficMonthly;
        $trafic['single'] = $singleTrafics;

        // Business
        $business = [];
        $business['all'] = Business::all();
        $business['submission'] = count(BusinessSubmission::where('status', 'review')->get());
        $business['submission_latest'] = BusinessSubmission::orderBy('id', 'DESC')->limit(5)->get();
        $business['this_account'] = Business::where('uuid', Auth::user()->business_uuid)->first();

        // User
        $user = [];
        $user['pengurus'] = count(User::where('role', 'Pengurus')->get());

        return view('Admin.dashboard', [
            'title' => 'Admin | E-Parking',
            'trafic' => $trafic,
            'business' => $business,
            'user' => $user
        ]);
    }
}
