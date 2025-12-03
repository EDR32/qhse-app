<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\Master\Unit;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UnitPage extends Component
{
    use WithPagination;

    public $unit_id;
    public $no_unit, $jenis_unit, $kategori;

    public $search = '';

    public function render()
    {
        $units = Unit::search($this->search)
            ->orderBy('no_unit', 'asc')
            ->paginate(10);

        return view('livewire.master.unit-page', [
            'units' => $units,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->openModal();
    }

    public function openModal()
    {
        $this->dispatch('open-modal', 'unit-form-modal');
    }

    private function resetForm()
    {
        $this->unit_id = null;
        $this->no_unit = '';
        $this->jenis_unit = '';
        $this->kategori = '';
    }

    public function store()
    {
        $this->validate([
            'no_unit' => 'required|string|max:255',
            'jenis_unit' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        Unit::updateOrCreate(['id' => $this->unit_id], [
            'no_unit' => $this->no_unit,
            'jenis_unit' => $this->jenis_unit,
            'kategori' => $this->kategori,
        ]);

        session()->flash('success', $this->unit_id ? 'Data Unit berhasil diperbarui.' : 'Data Unit berhasil ditambahkan.');

        $this->dispatch('close-modal', 'unit-form-modal');
        $this->resetForm();
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unit_id = $id;
        $this->no_unit = $unit->no_unit;
        $this->jenis_unit = $unit->jenis_unit;
        $this->kategori = $unit->kategori;

        $this->openModal();
    }

    public function delete($id)
    {
        try {
            Unit::find($id)->delete();
            session()->flash('success', 'Data Unit berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus data unit. Kemungkinan data ini digunakan di tempat lain.');
        }
    }
}