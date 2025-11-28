<?php

namespace App\Livewire;

use App\Models\Master\Unit;
use App\Models\StoringEvent;
use App\Models\UnitMonthlyReport;
use Livewire\Component;

class ViolationShowUnit extends Component
{
    public Unit $unit;
    public $totalKilometer = 0;
    public $storingEventCount = 0;

    public function mount(Unit $unit)
    {
        $this->unit = $unit;
        
        // Manually query across database connections
        // These models use the default 'pgsql' connection by default
        
        // Calculate total kilometers
        $this->totalKilometer = UnitMonthlyReport::where('unit_id', $this->unit->id)->sum('kilometer');
        
        // Get related report IDs to count storing events
        $reportIds = UnitMonthlyReport::where('unit_id', $this->unit->id)->pluck('id');
        $this->storingEventCount = StoringEvent::whereIn('unit_monthly_report_id', $reportIds)->count();
    }

    public function render()
    {
        return view('livewire.violation-show-unit');
    }
}
