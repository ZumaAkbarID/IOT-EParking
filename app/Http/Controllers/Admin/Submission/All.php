<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use App\Models\BusinessSubmission;
use Illuminate\Http\Request;

class All extends Controller
{
    public function index()
    {
        $submission = [];
        $submission['review'] = BusinessSubmission::where('status', 'review')->get();
        $submission['approved'] = BusinessSubmission::where('status', 'approved')->get();
        $submission['rejected'] = BusinessSubmission::where('status', 'rejected')->get();

        return view('Admin.Submission.all', [
            'title' => 'Pengajuan | E-Parking',
            'data' => $submission
        ]);
    }
}
