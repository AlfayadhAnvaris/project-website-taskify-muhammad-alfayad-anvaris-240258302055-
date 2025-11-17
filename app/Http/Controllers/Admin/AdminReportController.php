<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')->latest()->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    public function approve(Report $report)
    {
        $report->update([
            'status' => 'approved',
            'admin_note' => request('note')
        ]);

        return back()->with('success', 'Laporan telah disetujui.');
    }

    public function reject(Report $report)
    {
        $report->update([
            'status' => 'rejected',
            'admin_note' => request('note')
        ]);

        return back()->with('success', 'Laporan ditolak.');
    }
}
