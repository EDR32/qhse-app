<?php

namespace App\Livewire\Master;

use App\Models\Master\Driver;
use App\Models\Master\Karyawan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DriverPage extends Component
{
    use WithPagination;

    // Driver properties
    public $driver_id, $karyawan_id, $driver_category, $sim_type, $sim_expiry_date, $status;

    // Search and form state
    public $search = '';
    public $karyawanSearch = '';
    public $karyawanSearchResults = [];
    public $selectedKaryawanName = '';

    // Validation rules
    protected function rules()
    {
        return [
            'karyawan_id' => 'required|integer|exists:pgsql_master.m_karyawan,id|unique:pgsql_master.m_drivers,karyawan_id,' . $this->driver_id,
            'driver_category' => 'required|string|in:DUMPTRUCK,TRAILER,PROJECT',
            'sim_type' => 'nullable|string|max:50',
            'sim_expiry_date' => 'nullable|date',
            'status' => 'required|string|max:50',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $drivers = Driver::with('karyawan')
            ->where(function($query) {
                $query->where('driver_category', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('karyawan', function ($subQuery) {
                        $subQuery->where('nama_karyawan', 'like', '%' . $this->search . '%')
                                 ->orWhere('payroll_id', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.master.driver-page', compact('drivers'));
    }

    public function updatedKaryawanSearch($value)
    {
        if (strlen($this->karyawanSearch) < 2) {
            $this->karyawanSearchResults = [];
            return;
        }

        $this->karyawanSearchResults = Karyawan::where(function ($query) use ($value) {
                $query->where('nama_karyawan', 'like', '%' . $value . '%')
                      ->orWhere('payroll_id', 'like', '%' . $value . '%');
            })
            ->whereDoesntHave('driver') // Only show employees who are not already drivers
            ->limit(5)
            ->get();
    }

    public function selectKaryawan($karyawanId, $karyawanName)
    {
        $this->karyawan_id = $karyawanId;
        $this->selectedKaryawanName = $karyawanName;
        $this->karyawanSearch = '';
        $this->karyawanSearchResults = [];
    }


    private function resetForm()
    {
        $this->driver_id = null;
        $this->karyawan_id = null;
        $this->driver_category = 'DUMPTRUCK';
        $this->sim_type = '';
        $this->sim_expiry_date = '';
        $this->status = 'active';
        $this->karyawanSearch = '';
        $this->karyawanSearchResults = [];
        $this->selectedKaryawanName = '';
    }

    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'driver-form-modal');
    }

    public function store()
    {
        $validatedData = $this->validate();

        Driver::updateOrCreate(['id' => $this->driver_id], $validatedData);

        session()->flash('success', $this->driver_id ? 'Data Driver berhasil diperbarui.' : 'Data Driver berhasil ditambahkan.');

        $this->dispatch('close-modal', 'driver-form-modal');
        $this->resetForm();
    }

    public function edit($id)
    {
        $driver = Driver::with('karyawan')->findOrFail($id);

        $this->driver_id = $id;
        $this->karyawan_id = $driver->karyawan_id;
        $this->driver_category = $driver->driver_category;
        $this->sim_type = $driver->sim_type;
        $this->sim_expiry_date = $driver->sim_expiry_date ? date('Y-m-d', strtotime($driver->sim_expiry_date)) : null;
        $this->status = $driver->status;
        
        $this->selectedKaryawanName = $driver->karyawan->nama_karyawan . ' (' . $driver->karyawan->payroll_id . ')';
        
        $this->dispatch('open-modal', 'driver-form-modal');
    }

    public function delete($id)
    {
        try {
            Driver::find($id)->delete();
            session()->flash('success', 'Data Driver berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus data driver. Kemungkinan data ini digunakan di tempat lain.');
        }
    }
}