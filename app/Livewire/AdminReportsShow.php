<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;

class AdminReportsShow extends Component
{
    public $report;
    public $totalReports;

    public function mount(Report $report)
    {
        $this->report = $report;
        $this->totalReports = Report::count();
    }

    public function approveReport()
    {
        $this->report->update([
            'status' => 'approved',
        ]);

        session()->flash('success', 'Report berhasil disetujui.');
    }

    public function rejectReport()
    {
        $this->report->update([
            'status' => 'rejected',
        ]);

        session()->flash('error', 'Report ditolak.');
    }

    public function render()
    {
        return view('livewire.admin-reports-show', [
            'report' => $this->report,
            'totalReports' => $this->totalReports,
        ]);
    }
}
