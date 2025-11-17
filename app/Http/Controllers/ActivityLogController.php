<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan daftar aktivitas pengguna.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(10); // pagination biar rapi

        return view('admin.logs.index', compact('logs'));
    }

    /**
     * (Opsional) Tampilkan detail log tertentu.
     */
    public function show($userId)
{
    $logs = ActivityLog::with('user')
        ->where('user_id', $userId)
        ->latest()
        ->paginate(10);

    return view('admin.logs.index', compact('logs'));
}


    /**
     * (Opsional) Hapus log tertentu.
     */
  public function destroy(ActivityLog $log)
{
    $log->delete();

    return redirect()
        ->route('admin.logs.index')
        ->with('success', 'Log aktivitas berhasil dihapus.');
}


    /**
     * (Opsional) Hapus semua log.
     */
    public function clearAll()
    {
        ActivityLog::truncate();
        return redirect()->back()->with('success', 'Semua log aktivitas berhasil dihapus.');
    }
}
