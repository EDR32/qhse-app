<?php

namespace App\Livewire;

use App\Models\Accident;
use App\Models\RootCauseAnalysis;
use Livewire\Component;

class RcaCreate extends Component
{
    public Accident $accident;

    // Form properties
    public $analysis_method;
    public $root_cause_summary;
    public $root_cause_category;
    public $is_human_factor = false;
    public $is_equipment_factor = false;
    public $is_material_factor = false;
    public $is_method_factor = false;
    public $is_environment_factor = false;

    protected $rules = [
        'analysis_method' => 'nullable|string|max:255',
        'root_cause_summary' => 'required|string',
        'root_cause_category' => 'nullable|string|max:255',
        'is_human_factor' => 'boolean',
        'is_equipment_factor' => 'boolean',
        'is_material_factor' => 'boolean',
        'is_method_factor' => 'boolean',
        'is_environment_factor' => 'boolean',
    ];

    public function mount(Accident $accident)
    {
        if ($accident->rca) {
            session()->flash('error', 'Root Cause Analysis untuk insiden ini sudah ada.');
            return redirect()->route('accidents.show', $accident);
        }
        $this->accident = $accident;
    }

    public function save()
    {
        $this->validate();

        $rca = RootCauseAnalysis::create([
            'accident_id' => $this->accident->id,
            'analysis_method' => $this->analysis_method,
            'root_cause_summary' => $this->root_cause_summary,
            'root_cause_category' => $this->root_cause_category,
            'is_human_factor' => $this->is_human_factor,
            'is_equipment_factor' => $this->is_equipment_factor,
            'is_material_factor' => $this->is_material_factor,
            'is_method_factor' => $this->is_method_factor,
            'is_environment_factor' => $this->is_environment_factor,
        ]);

        session()->flash('message', 'Root Cause Analysis berhasil dibuat.');

        return redirect()->route('rca.show', $rca);
    }

    public function render()
    {
        return view('livewire.rca-create')->layout('layouts.app');
    }
}
