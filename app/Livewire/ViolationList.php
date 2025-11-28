<?php

namespace App\Livewire;

use App\Models\Master\Unit;
use App\Models\Violation;
use Livewire\Component;
use Livewire\WithPagination;

class ViolationList extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public function render()
    {
        $violations = Violation::all();
        $units = Unit::simplePaginate(5);
        return view('livewire.violation-list', [
            'violations' => $violations,
            'units' => $units
        ]);
    }
}