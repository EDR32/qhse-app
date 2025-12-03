<?php

namespace App\Livewire;

use App\Models\Master\Driver;
use App\Models\Master\Unit;
use App\Models\Violation;
use Livewire\Component;
use Livewire\WithPagination;

class ViolationList extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public $unitSearch = '';
    public $driverSearch = '';

    public function updatedUnitSearch()
    {
        $this->resetPage('unitsPage');
    }

    public function updatedDriverSearch()
    {
        $this->resetPage('driversPage');
    }

    public function render()
    {
        $violations = Violation::all();

        $units = Unit::query()
            ->when($this->unitSearch, function ($query) {
                $query->where('no_unit', 'ilike', '%' . $this->unitSearch . '%');
            })
            ->simplePaginate(5, ['*'], 'unitsPage');
        
        $drivers = Driver::with('karyawan')
            ->when($this->driverSearch, function ($query) {
                $query->where('driver_category', 'ilike', '%' . $this->driverSearch . '%')
                    ->orWhereHas('karyawan', function ($subQuery) {
                        $subQuery->where('nama_karyawan', 'ilike', '%' . $this->driverSearch . '%')
                                 ->orWhere('payroll_id', 'ilike', '%' . $this->driverSearch . '%');
                    });
            })
            ->simplePaginate(5, ['*'], 'driversPage');

        return view('livewire.violation-list', [
            'violations' => $violations,
            'units' => $units,
            'drivers' => $drivers,
        ]);
    }
}