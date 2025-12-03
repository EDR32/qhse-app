<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Master\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserManagementPage extends Component
{
    use WithPagination;

    public $search = '';
    public ?User $userToEdit = null;
    public $allRoles = [];
    public $userRoles = [];

    public function render()
    {
        $users = User::with('roles')
            ->where(function ($query) {
                if (!empty($this->search)) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%')
                          ->orWhere('payroll_id', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.user-management-page', [
            'users' => $users,
        ]);
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
            // Convert array values from string to int
            $roleIds = array_map('intval', $this->userRoles);

            $this->userToEdit->syncRoles($roleIds);
            session()->flash('success', 'Peran untuk pengguna ' . $this->userToEdit->name . ' berhasil diperbarui.');
            $this->dispatch('close-modal', 'edit-user-roles');
            $this->reset(['userToEdit', 'userRoles', 'allRoles']);
        }
    }
}