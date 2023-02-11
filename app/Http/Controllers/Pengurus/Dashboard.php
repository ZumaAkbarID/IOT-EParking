<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Report;
use App\Models\Trafic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        $trafics = Trafic::select(
            DB::raw('COUNT(type) as countType'),
            DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            DB::raw("EXTRACT(MONTH FROM `created_at`) as mon")
        )
            ->where('business_uuid', Auth::user()->business_uuid)
            ->whereBetween('created_at', [date('Y') . '-01-01 00:00:01', date('Y') . '-12-31 23:59:59'])
            ->groupBy('mon', 'year')->get();

        $traficMonthly = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($trafics as $trf) {
            $traficMonthly[$trf->mon - 1] = $trf->countType;
        }

        $trafic = [
            'monthly' => $traficMonthly,
            'all' => Trafic::where('business_uuid', Auth::user()->business_uuid)->get()
        ];

        $report = [
            'money_all' => Report::where('business_uuid', Auth::user()->business_uuid)->where('gate', 'gate_out')->sum('price_rate')
        ];

        $machine = [
            'total' => 0,
            'total_sensor' => 0
        ];
        $machines = Machine::where('business_uuid', Auth::user()->business_uuid)->get();
        foreach ($machines as $m) {
            $machine['total'] += 1;
            $machine['total_sensor'] += $m->total_sensor;
        }

        return view('Pengurus.dashboard', [
            'title' => 'Dashboard | E-Parking',
            'trafic' => $trafic,
            'report' => $report,
            'machine' => $machine
        ]);
    }
}
