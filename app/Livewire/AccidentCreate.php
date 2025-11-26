<?php

namespace App\Livewire;

use App\Models\Accident;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AccidentCreate extends Component
{
    use WithFileUploads;


    public $employee_payroll_id;
    public $employee_name;
    public $division;
    public $location;
    public $accident_date;
    public $description;
    public $initial_action;
    public $consequence;

    // Analysis Fields
    public $penyebab_dasar = '';
    public $penjelasan_penyebab_dasar = '';
    public $penyebab_langsung = '';
    public $kondisi_tidak_aman = '';
    public $kesimpulan = '';

    // New detailed columns
    public $employee_age_group;
    public $equipment_type;
    public $accident_time_range;
        public $financial_loss;
        public $injured_body_parts = []; // For checkboxes
        public $accident_types = []; // For checkboxes
        public $lost_work_days;
        public $photo_path; // For file upload
    
        // Properti untuk kerugian finansial yang lebih detail
        public $loss_categories = [
            'Evakuasi' => false,
            'Sosial' => false,
            'Aset' => false,
            'Fasilitas' => false,
        ];
        public $loss_amounts = [
            'Evakuasi' => '',
            'Sosial' => '',
            'Aset' => '',
            'Fasilitas' => '',
        ];
    
        public function updatedLossAmounts()
        {
            $total = 0;
            foreach ($this->loss_amounts as $amount) {
                $total += is_numeric($amount) ? (float)$amount : 0;
            }
            $this->financial_loss = $total;
        }

    public $userSearchResults = [];
    public $userSelected = false;

    // Using a lifecycle hook to search users when employee_name is updated.
    public function updatedEmployeeName(UserService $userService)
    {
        // If a user was just selected, don't re-run the search.
        if ($this->userSelected) {
            $this->userSelected = false;
            return;
        }

        if (strlen($this->employee_name) >= 1) {
            $this->userSearchResults = $userService->searchByNameOrNik($this->employee_name);
            Log::info('Searching for: ' . $this->employee_name . ', Results count: ' . $this->userSearchResults->count());
        } else {
            $this->userSearchResults = [];
            Log::info('Search query too short or empty, clearing results.');
        }
    }

    public function selectUser(string $payrollId, UserService $userService)
    {
        Log::info('selectUser method called with payrollId: ' . $payrollId);
        $employee = $userService->findByPayrollId($payrollId);

        if ($employee) {
            Log::info('Employee found: ' . $employee->nama_karyawan . ' (Payroll ID: ' . $employee->payroll_id . ')');
            
            $this->userSelected = true;
            $this->employee_name = $employee->nama_karyawan;
            $this->employee_payroll_id = $employee->payroll_id;
            $this->division = $employee->div_name;

            // Calculate age group
            if ($employee->tgl_lahir) {
                try {
                    $birthDate = Carbon::createFromFormat('d/m/Y', $employee->tgl_lahir);
                    $this->employee_age_group = $birthDate->age . ' tahun';
                } catch (\Exception $e) {
                    $this->employee_age_group = 'N/A'; // Handle potential parse error
                    Log::error('Could not parse date of birth: ' . $employee->tgl_lahir);
                }
            } else {
                $this->employee_age_group = 'N/A';
            }
            
            $this->userSearchResults = []; // Clear search results
            $this->resetErrorBag(['employee_payroll_id', 'employee_name']);
            Log::info('Component properties set: employee_name=' . $this->employee_name . ', employee_payroll_id=' . $this->employee_payroll_id);
        } else {
            Log::warning('Employee not found for payrollId: ' . $payrollId);
        }
    }

    public function changeUser()
    {
        $this->userSelected = false;
        $this->employee_payroll_id = '';
        $this->employee_name = '';
        $this->division = '';
        $this->employee_age_group = '';
    }

    protected $rules = [
        'employee_payroll_id' => 'required|string',
        'employee_name' => 'required|string',
        'division' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'accident_date' => 'required|date',
        'description' => 'required|string',
        'initial_action' => 'nullable|string',
        'consequence' => 'nullable|string',

        // Validation for new detailed columns
        'employee_age_group' => 'nullable|string|max:255',
        'equipment_type' => 'nullable|string|max:255',
        'accident_time_range' => 'nullable|string|max:255',
        'financial_loss' => 'nullable|numeric|min:0',
        'injured_body_parts' => 'nullable|array',
        'accident_types' => 'nullable|array',
        'lost_work_days' => 'nullable|integer|min:0',
        'photo_path' => 'nullable|image|max:1024', // Max 1MB

        // Validation for analysis fields
        'penyebab_dasar' => 'nullable|string',
        'penjelasan_penyebab_dasar' => 'nullable|string',
        'penyebab_langsung' => 'nullable|string',
        'kondisi_tidak_aman' => 'nullable|string',
        'kesimpulan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo_path) {
            $photoPath = $this->photo_path->store('photos', 'public');
        }

        Accident::create([
            'user_id' => Auth::id(), // Reporter ID
            'employee_payroll_id' => $this->employee_payroll_id,
            'employee_name' => $this->employee_name,
            'division' => $this->division,
            'location' => $this->location,
            'accident_date' => $this->accident_date,
            'description' => $this->description,
            'initial_action' => $this->initial_action,
            'consequence' => $this->consequence,

            // New detailed columns
            'employee_age_group' => $this->employee_age_group,
            'equipment_type' => $this->equipment_type,
            'accident_time_range' => $this->accident_time_range,
            'financial_loss' => $this->financial_loss,
            'injured_body_parts' => $this->injured_body_parts,
            'accident_types' => $this->accident_types,
            'lost_work_days' => $this->lost_work_days,
            'photo_path' => $photoPath,

            // Analysis fields
            'penyebab_dasar' => $this->penyebab_dasar,
            'penjelasan_penyebab_dasar' => $this->penjelasan_penyebab_dasar,
            'penyebab_langsung' => $this->penyebab_langsung,
            'kondisi_tidak_aman' => $this->kondisi_tidak_aman,
            'kesimpulan' => $this->kesimpulan,
        ]);

        session()->flash('message', 'Laporan kecelakaan berhasil dibuat.');

        return redirect()->route('accidents.index');
    }

    public function render()
    {
        return view('livewire.accident-create')->layout('layouts.app');
    }
}
