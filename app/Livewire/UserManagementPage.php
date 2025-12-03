<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Master\Role;
use App\Models\Master\Karyawan;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserManagementPage extends Component
{
    use WithPagination;

    public $search = '';
    public ?User $userToEdit = null;
    public $allRoles = [];
    public $userRoles = [];

    // Properties for creating a new user (integrated into the main list)
    public ?Karyawan $selectedKaryawan = null;

    public function render()
    {
        $perPage = 15;
        $items = new Collection();

        if (empty($this->search)) {
            // If search is empty, only show existing users.
            $users = User::with('roles', 'karyawan')->orderBy('name')->get();
            foreach ($users as $user) {
                $items->push((object)[
                    'type' => 'user',
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'payroll_id' => $user->payroll_id,
                    'roles' => $user->roles,
                    'original_user_object' => $user,
                ]);
            }
        } else {
            // If search is active, show merged results.
            $usersQuery = User::with('roles', 'karyawan')
                ->where(function ($query) {
                    $query->where('name', 'ilike', '%' . $this->search . '%')
                          ->orWhere('email', 'ilike', '%' . $this->search . '%')
                          ->orWhere('payroll_id', 'ilike', '%' . $this->search . '%')
                          ->orWhereHas('karyawan', function ($q) {
                              $q->where('nama_karyawan', 'ilike', '%' . $this->search . '%');
                          });
                });

            $karyawanQuery = Karyawan::whereDoesntHave('user')
                ->where(function ($query) {
                    $query->where('nama_karyawan', 'ilike', '%' . $this->search . '%')
                          ->orWhere('payroll_id', 'ilike', '%' . $this->search . '%');
                });

            $usersResult = $usersQuery->get();
            $karyawanResult = $karyawanQuery->get();

            foreach ($usersResult as $user) {
                $items->push((object)[
                    'type' => 'user',
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'payroll_id' => $user->payroll_id,
                    'roles' => $user->roles,
                    'original_user_object' => $user,
                ]);
            }

            foreach ($karyawanResult as $karyawan) {
                $items->push((object)[
                    'type' => 'karyawan',
                    'id' => $karyawan->id,
                    'name' => $karyawan->nama_karyawan,
                    'email' => strtolower($karyawan->payroll_id) . '@bcs-logistics.co.id',
                    'payroll_id' => $karyawan->payroll_id,
                    'roles' => collect(),
                    'original_karyawan_object' => $karyawan,
                ]);
            }
        }

        // Sort and manually paginate the final collection
        $sortedItems = $items->sortBy('name');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedItems->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedResults = new LengthAwarePaginator($currentItems, $sortedItems->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.user-management-page', [
            'users' => $paginatedResults,
        ]);
    }

    public function resetSearchState()
    {
        $this->reset(['selectedKaryawan']); // Clear any selected karyawan if needed
    }

    public function editUser(User $user)
    {
        $this->userToEdit = $user;
        $this->userRoles = $user->roles->pluck('id')->toArray();
        $this->allRoles = Role::orderBy('name')->get(); // Fetch all roles for the modal
        $this->dispatch('open-modal', 'edit-user-roles');
    }

    public function updateUserRoles()
    {
        $this->validate([
            'userRoles' => 'array',
            'userRoles.*' => 'integer|exists:pgsql_master.roles,id',
        ]);

        if ($this->userToEdit) {
            $roleIds = array_map('intval', $this->userRoles);
            $this->userToEdit->syncRoles($roleIds);
            session()->flash('success', 'Peran untuk pengguna ' . $this->userToEdit->name . ' berhasil diperbarui.');
            $this->dispatch('close-modal', 'edit-user-roles');
            $this->reset(['userToEdit', 'userRoles', 'allRoles']);
        }
    }

    public function createUserFromKaryawan(int $karyawanId)
    {
        $karyawan = Karyawan::find($karyawanId);

        if (!$karyawan) {
            session()->flash('error', 'Karyawan tidak ditemukan.');
            return;
        }

        if (User::where('payroll_id', $karyawan->payroll_id)->exists()) {
            session()->flash('error', 'Pengguna untuk karyawan ini sudah ada.');
            return;
        }

        User::create([
            'name' => $karyawan->nama_karyawan,
            'payroll_id' => $karyawan->payroll_id,
            'email' => strtolower($karyawan->payroll_id) . '@bcs-logistics.co.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        session()->flash('success', 'Pengguna untuk ' . $karyawan->nama_karyawan . ' berhasil dibuat.');
        $this->resetPage();
    }
}