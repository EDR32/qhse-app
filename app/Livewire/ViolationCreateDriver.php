<?php

namespace App\Livewire;

use App\Models\Master\Karyawan;
use App\Models\User;
use App\Models\Violation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViolationCreateDriver extends Component
{
    // Property for filtering driver based on URL param
    public string $driver_type = ''; // 'dumptruck', 'trailer', 'project'

    // Properti untuk filter dan pencarian driver
    public $driver_search = '';
    public $searchResults = [];
    public $selectedKaryawanName;

    // Properti untuk form
    public $karyawan_id;
    public $user_id; // untuk disimpan di tabel violations
    public $violation_date;
    public $violation_category;
    public $description;
    public $sanction;
    public $location;

    // Hardcoded violation categories from user's CSV
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

    protected function rules()
    {
        return [
            'driver_type' => 'required|in:dumptruck,trailer,project', // Validate driver_type from URL
            'karyawan_id' => 'required', // We need to ensure a Karyawan is selected
            'user_id' => 'required',
            'violation_date' => 'required|date',
            'violation_category' => 'required|string',
            'description' => 'required|string|min:10',
            'sanction' => 'nullable|string',
            'location' => 'required|string',
        ];
    }

    public function mount()
    {
        // Initialize driver_type from URL query parameter
        $this->driver_type = request()->query('driver_type', '');
        
        // Redirect if driver_type is not provided or invalid
        if (!in_array($this->driver_type, ['dumptruck', 'trailer', 'project'])) {
            session()->flash('error', 'Tipe driver tidak valid. Silakan pilih kategori driver terlebih dahulu.');
            return $this->redirectRoute('violations.index'); // Redirect to a safe page
        }

        $this->violation_date = Carbon::now()->format('Y-m-d');
        $this->location = 'Area Proyek'; // Default value
    }

    public function updatedDriverSearch()
    {
        if (strlen($this->driver_search) < 2) {
            $this->searchResults = [];
            return;
        }

        $title = ($this->driver_type === 'project') ? 'DRIVER PROJECT' : 'DRIVER';

        $this->searchResults = Karyawan::where('title', $title)
            ->where(function ($query) {
                $query->where('nama_karyawan', 'ilike', '%' . $this->driver_search . '%')
                    ->orWhere('payroll_id', 'ilike', '%' . $this->driver_search . '%');
            })
            ->where('aktif', true)
            ->take(5)
            ->get();
    }

    public function selectKaryawan($karyawanId)
    {
        $karyawan = Karyawan::find($karyawanId);
        if ($karyawan) {
            // Cari user yang berelasi dengan karyawan
            $user = User::where('karyawan_id', $karyawan->id)->first();

            if (!$user) {
                // Handle jika user tidak ditemukan, mungkin dengan notifikasi error
                $this->addError('driver_search', 'Driver ini tidak memiliki akun pengguna aplikasi yang aktif.');
                $this->searchResults = [];
                $this->driver_search = '';
                return;
            }

            $this->karyawan_id = $karyawan->id;
            $this->user_id = $user->id; // simpan user_id yang berelasi
            $this->selectedKaryawanName = $karyawan->nama_karyawan . ' (' . $karyawan->payroll_id . ')';
            $this->searchResults = [];
            $this->driver_search = '';
        }
    }

    public function changeKaryawan()
    {
        $this->karyawan_id = null;
        $this->user_id = null;
        $this->selectedKaryawanName = null;
        $this->driver_search = '';
        $this->searchResults = [];
    }
    
    public function save()
    {
        $this->validate();

        // Gabungkan sanksi ke deskripsi jika ada
        $fullDescription = $this->description;
        if (!empty($this->sanction)) {
            $fullDescription .= "\n\nSanksi yang diberikan: " . $this->sanction;
        }

        Violation::create([
            'user_id' => $this->user_id, // Menyimpan ID user yang terkait dengan driver
            'location' => $this->location,
            'violation_date' => $this->violation_date,
            'description' => $fullDescription,
            'rule_broken' => $this->violation_category,
        ]);

        session()->flash('success', 'Data pelanggaran berhasil disimpan.');

        return $this->redirectRoute('violations.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // Map driver_type to a more readable format for display
        $displayDriverType = match ($this->driver_type) {
            'dumptruck' => 'Dumptruck',
            'trailer' => 'Trailer',
            'project' => 'Project',
            default => 'Unknown',
        };

        return view('livewire.violation-create-driver', [
            'displayDriverType' => $displayDriverType,
        ]);
    }
}