<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('success'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Daftar Pengguna / Karyawan
                    </h3>
                    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari nama, email, atau NIK..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full sm:w-64" />
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peran / Status</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $item) {{-- $users now contains mixed User and Karyawan objects --}}
                                <tr wire:key="{{ $item->type }}-{{ $item->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->payroll_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $item->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        @if ($item->type === 'user')
                                            @forelse ($item->roles as $role)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Tanpa Peran
                                                </span>
                                            @endforelse
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Belum Pengguna
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($item->type === 'user')
                                            <x-button wire:click="editUser({{ $item->original_user_object->id }})">
                                                Ubah Peran
                                            </x-button>
                                        @else
                                            <x-button wire:click="createUserFromKaryawan({{ $item->original_karyawan_object->id }})">
                                                Jadikan Pengguna
                                            </x-button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Tidak ada pengguna atau karyawan yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Roles Modal -->
    <x-modal name="edit-user-roles" focusable>
        @if ($userToEdit)
            <form wire:submit.prevent="updateUserRoles" class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Ubah Peran untuk: <span class="font-bold">{{ $userToEdit->name }}</span>
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Pilih peran yang ingin diberikan kepada pengguna ini.
                </p>

                <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($allRoles as $role)
                        <label for="role-{{ $role->id }}" class="flex items-center">
                            <input id="role-{{ $role->id }}" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.live="userRoles" value="{{ $role->id }}" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="closeModal" x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-button class="ms-3" type="submit">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        @endif
    </x-modal>
</div>
