<?php

namespace App\Livewire;

use App\Models\Master\Driver;
use App\Models\Violation;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ViolationShowDriver extends Component
{
    use WithPagination;

    public Driver $driver;

    public function mount(Driver $driver)
    {
        $this->driver = $driver->load('karyawan.user');
    }

    public function render()
    {
        $violations = collect();

        // Ensure user relationship is loaded and exists before trying to access it
        if ($this->driver->karyawan && $this->driver->karyawan->user) {
            $violations = Violation::where('user_id', $this->driver->karyawan->user->id)
                ->latest()
                ->paginate(10);
        }

        return view('livewire.violation-show-driver', [
            'violations' => $violations
        ]);
    }
}
