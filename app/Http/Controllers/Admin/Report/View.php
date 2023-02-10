<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class View extends Controller
{
    public function all()
    {
        $reportBusinesses = Report::select(
            DB::raw('SUM(price_rate) as money'),
            DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            DB::raw("EXTRACT(MONTH FROM `created_at`) as mon")
        )
            ->whereBetween('created_at', [date('Y') . '-01-01 00:00:01', date('Y') . '-12-31 23:59:59'])
            ->groupBy('mon', 'year')->get();

        $singleReport = Report::select(
            DB::raw('SUM(price_rate) as money'),
            DB::raw('COUNT(gate)'),
            DB::raw('business_uuid'),
            DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
        )
            ->whereBetween('created_at', [date('Y') . '-01-01 00:00:01', date('Y') . '-12-31 23:59:59'])
            ->groupBy('business_uuid', 'year')->get();

        $data = [
            'business_all' => Business::all(),
            'business_single' => $singleReport,
        ];

        $reportBusiness = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $yearly_report = 0;
        foreach ($reportBusinesses as $report) {
            $reportBusiness[$report->mon - 1] = $report->money;
            $yearly_report += $report->money;
        }

        $data['monthly_report'] = $reportBusiness;
        $data['yearly_report'] = $yearly_report;

        return view('Admin.Report.view', [
            'title' => 'Laporan | E-Parking',
            'data' => $data
        ]);
    }
}