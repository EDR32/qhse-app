<?php

namespace App\Livewire;

use App\Models\Violation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ViolationEdit extends Component
{
    public Violation $violation;

    // Form properties
    public $location;
    public $violation_date;
    public $description;
    public $rule_broken;

    // Hardcoded violation categories for the dropdown
    public $violationCategories = [
        'Fatigue',
        'Distraction',
        'Field of View (FOV)',
        'Rest Area Policy',
        'Pelanggaran Jam Larangan',
        'Accident',
        'Overspeed',
        'Continuous Driving',
        'Cell Phone Use',
        'Keikutsertaan DDT',
        'Penggunaan BCS Fit',
        'Lainnya',
    ];

    public function mount(Violation $violation)
    {
        $this->violation = $violation->load('user.karyawan.driver');
        $this->location = $violation->location;
        // The cast on the model might not be datetime, so check before formatting
        $this->violation_date = $violation->violation_date ? date('Y-m-d', strtotime($violation->violation_date)) : null;
        $this->description = $violation->description;
        $this->rule_broken = $violation->rule_broken;
    }

    protected function rules()
    {
        return [
            'location' => 'required|string',
            'violation_date' => 'required|date',
            'description' => 'required|string|min:10',
            'rule_broken' => 'required|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->violation->update([
            'location' => $this->location,
            'violation_date' => $this->violation_date,
            'description' => $this->description,
            'rule_broken' => $this->rule_broken,
        ]);

        session()->flash('success', 'Data pelanggaran berhasil diperbarui.');

        // Redirect to the driver's detail page
        return $this->redirectRoute('violations.show.driver', ['driver' => $this->violation->user->karyawan->driver->id]);
    }

    public function render()
    {
        return view('livewire.violation-edit');
    }
}
