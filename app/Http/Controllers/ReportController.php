<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('user.reports.create');
    }
public function store(Request $request)
{
    $request->validate([
        'title'      => 'required|string|max:255',
        'category'   => 'required',
        'content'    => 'required',
        'attachment' => 'nullable|file|max:2048',
    ]);

    $data = $request->only(['title', 'category', 'content']);

    // Handle file upload
    if ($request->hasFile('attachment')) {
        $data['attachment'] = $request->file('attachment')->store('reports', 'public');
    }

    // Add the authenticated user's ID
    $data['user_id'] = Auth::id();

    // Create the report
    Report::create($data);

    return redirect()->route('user.reports.index')
                     ->with('success', 'Laporan berhasil dikirim!');
}

}

