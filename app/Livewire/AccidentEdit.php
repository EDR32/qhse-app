<?php

namespace App\Livewire;

use App\Models\Accident;
use App\Models\Master\Unit;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AccidentEdit extends Component
{
    use WithFileUploads;

    public Accident $accident;

    // Properties to hold accident data
    public $employee_payroll_id;
    public $employee_name;
    public $division;
    public $employee_age_group;
    public $location;
    public $accident_date;
    public $accident_time_range;
    public $description;
    public $initial_action;
    public $consequence;
    public $financial_loss;
    public $injured_body_parts = [];
    public $accident_types = [];
    public $lost_work_days;
    
    // Analysis Fields
    public $penyebab_dasar;
    public $penjelasan_penyebab_dasar;
    public $penyebab_langsung;
    public $kondisi_tidak_aman;
    public $kesimpulan;

    // File Upload Properties
    public $photo_path; // For new file upload
    public $current_photo_path; // To display existing photo

    // Properties for Unit Search
    public $m_unit_id;
    public $unit_search = '';
    public $unitSearchResults = [];
    public $unitSelected = false;
    public $selectedUnitName = '';


    public function mount(Accident $accident)
    {
        $this->accident = $accident;

        // Populate all the fields from the model
        $this->employee_payroll_id = $accident->employee_payroll_id;
        $this->employee_name = $accident->employee_name;
        $this->division = $accident->division;
        $this->employee_age_group = $accident->employee_age_group;
        $this->location = $accident->location;
        $this->accident_date = $accident->accident_date ? $accident->accident_date->format('Y-m-d') : null;
        $this->accident_time_range = $accident->accident_time_range;
        $this->description = $accident->description;
        $this->initial_action = $accident->initial_action;
        $this->consequence = $accident->consequence;
        $this->financial_loss = $accident->financial_loss;
        $this->lost_work_days = $accident->lost_work_days;
        $this->current_photo_path = $accident->photo_path;
        
        $this->injured_body_parts = $accident->injured_body_parts ?? [];
        $this->accident_types = $accident->accident_types ?? [];

        // Populate analysis fields
        $this->penyebab_dasar = $accident->penyebab_dasar;
        $this->penjelasan_penyebab_dasar = $accident->penjelasan_penyebab_dasar;
        $this->penyebab_langsung = $accident->penyebab_langsung;
        $this->kondisi_tidak_aman = $accident->kondisi_tidak_aman;
        $this->kesimpulan = $accident->kesimpulan;

        // Populate unit fields if a unit is associated
        if ($accident->m_unit_id && $accident->unit) {
            $this->m_unit_id = $accident->m_unit_id;
            $this->selectedUnitName = $accident->unit->no_unit;
            $this->unit_search = $accident->unit->no_unit;
            $this->unitSelected = true;
        }
    }

    public function updatedUnitSearch()
    {
        Log::info('Searching for unit: ' . $this->unit_search);
        if (strlen($this->unit_search) >= 2) {
            $searchTerm = trim($this->unit_search);
            $this->unitSearchResults = Unit::whereRaw('TRIM(no_unit) ILIKE ?', ['%' . $searchTerm . '%'])
                ->take(5)
                ->get();
            Log::info('Found ' . $this->unitSearchResults->count() . ' units.');
        } else {
            $this->unitSearchResults = [];
        }
    }

    public function selectUnit($unitId)
    {
        $unit = Unit::find($unitId);
        if ($unit) {
            $this->m_unit_id = $unit->id;
            $this->selectedUnitName = $unit->no_unit;
            $this->unit_search = $unit->no_unit;
            $this->unitSelected = true;
            $this->unitSearchResults = [];
        }
    }

    public function changeUnit()
    {
        $this->m_unit_id = null;
        $this->selectedUnitName = '';
        $this->unit_search = '';
        $this->unitSelected = false;
        $this->unitSearchResults = [];
    }

    protected function rules()
    {
        return [
            'employee_payroll_id' => 'required|string',
            'employee_name' => 'required|string',
            'division' => 'required|string',
            'location' => 'required|string|max:255',
            'accident_date' => 'required|date',
            'description' => 'required|string',
            'initial_action' => 'nullable|string',
            'consequence' => 'nullable|string',
            'employee_age_group' => 'nullable|string|max:255',
            'm_unit_id' => 'nullable|integer|exists:pgsql_master.m_unit,id',
            'accident_time_range' => 'nullable|string|max:255',
            'financial_loss' => 'nullable|numeric|min:0',
            'injured_body_parts' => 'nullable|array',
            'accident_types' => 'nullable|array',
            'lost_work_days' => 'nullable|integer|min:0',
            'photo_path' => 'nullable|image|max:1024',
            'penyebab_dasar' => 'nullable|string',
            'penjelasan_penyebab_dasar' => 'nullable|string',
            'penyebab_langsung' => 'nullable|string',
            'kondisi_tidak_aman' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ];
    }

    public function update()
    {
        $validatedData = $this->validate();

        // Manually add m_unit_id to the data to be saved, as it's not part of the standard form validation array by default
        $validatedData['m_unit_id'] = $this->m_unit_id;

        if ($this->photo_path) {
            if ($this->current_photo_path) {
                Storage::disk('public')->delete($this->current_photo_path);
            }
            $validatedData['photo_path'] = $this->photo_path->store('photos', 'public');
        }

        $this->accident->update($validatedData);

        session()->flash('message', 'Laporan kecelakaan berhasil diperbarui.');

        return redirect()->route('accidents.index');
    }

    public function render()
    {
        return view('livewire.accident-edit')->layout('layouts.app');
    }
}
