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


    public function render()
    {
        return view('livewire.admin-reports-show', [
            'report' => $this->report,
            'totalReports' => $this->totalReports,
        ]);
    }
}
