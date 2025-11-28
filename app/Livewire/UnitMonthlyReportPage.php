<?php

namespace App\Livewire;

use App\Models\Master\Unit as MasterUnit;
use App\Models\UnitMonthlyReport;
use App\Models\StoringEvent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout; // Import the Layout attribute

#[Layout('layouts.app')] // Define the layout for this component
class UnitMonthlyReportPage extends Component
{
    // Query string properties
    public $kategori;

    // Collections for dropdowns
    public $units = [];
    public $categories = [];

    // Selected items
    public $selectedUnitId;

    // The monthly report instance
    public ?UnitMonthlyReport $report = null;

    // Form fields
    public $kilometer = 0;
    public $storingEvents = [];

    // New storing event form
    public $newStoring = [
        'event_date' => '',
        'event_time' => '',
        'week_of_month' => 1,
        'location' => '',
        'description' => '',
    ];

    // UI state
    public $activeTab = 'minggu1';

    public function mount()
    {
        // Accept 'kategori' or 'type' from the query string
        $this->kategori = request()->query('kategori', request()->query('type', 'all'));
        
        $this->categories = MasterUnit::select('kategori')->distinct()->pluck('kategori');
        $this->loadUnits();
        $this->newStoring['event_date'] = today()->format('Y-m-d');
    }

    public function loadUnits()
    {
        $query = MasterUnit::orderBy('no_unit');
        if ($this->kategori && $this->kategori !== 'all') {
            $query->where('kategori', $this->kategori);
        }
        $this->units = $query->get();
    }

    public function updatedKategori()
    {
        // This method might not be needed anymore if the category is fixed, but we'll keep it for now.
        $this->loadUnits();
        $this->selectedUnitId = null; // Reset unit selection
        $this->report = null; // Reset report
    }

    public function updatedSelectedUnitId($unitId)
    {
        if (!$unitId) {
            $this->report = null;
            return;
        }

        $this->report = UnitMonthlyReport::firstOrCreate(
            [
                'unit_id' => $unitId,
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
            ],
            [
                'kilometer' => 0,
                'user_id' => Auth::id(),
            ]
        );

        $this->loadReportDetails();
    }

    public function loadReportDetails()
    {
        if ($this->report) {
            $this->kilometer = $this->report->kilometer;
            $this->storingEvents = $this->report->storingEvents()->orderBy('event_date')->get();
        }
    }

    public function saveKilometer()
    {
        $this->validate(['kilometer' => 'required|numeric|min:0']);

        if ($this->report) {
            $this->report->update(['kilometer' => $this->kilometer]);
            session()->flash('message', 'Kilometer berhasil diperbarui.');
        }
    }

    public function addStoringEvent()
    {
        $this->validate([
            'newStoring.event_date' => 'required|date',
            'newStoring.event_time' => 'required|date_format:H:i',
            'newStoring.location' => 'required|string|max:255',
            'newStoring.description' => 'required|string',
        ]);

        if (!$this->report) {
            session()->flash('error', 'Silakan pilih unit terlebih dahulu.');
            return;
        }

        // Determine week of month
        $date = Carbon::parse($this->newStoring['event_date']);
        $this->newStoring['week_of_month'] = $date->weekOfMonth;

        $this->report->storingEvents()->create([
            'event_date' => $this->newStoring['event_date'],
            'event_time' => $this->newStoring['event_time'],
            'week_of_month' => $this->newStoring['week_of_month'],
            'location' => $this->newStoring['location'],
            'description' => $this->newStoring['description'],
            'user_id' => Auth::id(),
        ]);

        // Reset form and reload events
        $this->reset('newStoring');
        $this->newStoring['event_date'] = today()->format('Y-m-d');
        $this->loadReportDetails();

        session()->flash('message', 'Temuan storing berhasil ditambahkan.');
    }
    
    public function render()
    {
        return view('livewire.unit-monthly-report-page');
    }
}