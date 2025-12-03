<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data Driver') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Daftar Driver
                    </h3>
                    <div class="flex space-x-4">
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari driver..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full sm:w-64" />
                        <x-button wire:click="create()">
                            {{ __('Tambah Driver') }}
                        </x-button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe SIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Masa Berlaku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($drivers as $driver)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $driver->karyawan->nama_karyawan ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $driver->karyawan->payroll_id ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $driver->driver_category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $driver->sim_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $driver->sim_expiry_date ? \Carbon\Carbon::parse($driver->sim_expiry_date)->format('d M Y') : '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $driver->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $driver->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <x-button wire:click="edit({{ $driver->id }})">Edit</x-button>
                                        <x-danger-button wire:click="delete({{ $driver->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?">Delete</x-danger-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300">
                                        Tidak ada data driver yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $drivers->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-modal name="driver-form-modal" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $driver_id ? 'Edit Driver' : 'Tambah Driver Baru' }}</h2>

            <div class="mt-6 space-y-4">
                <!-- Karyawan Search -->
                <div>
                    <label for="karyawanSearch" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Karyawan</label>
                    @if ($selectedKaryawanName)
                        <div class="flex items-center justify-between mt-1 p-2 bg-gray-100 border border-gray-300 rounded-md">
                            <span>{{ $selectedKaryawanName }}</span>
                            <button type="button" wire:click="resetForm()" class="text-sm text-indigo-600 hover:text-indigo-900">Ganti</button>
                        </div>
                    @else
                        <div class="relative">
                            <input id="karyawanSearch" type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model.live.debounce.300ms="karyawanSearch" placeholder="Cari NIK atau Nama Karyawan..." autocomplete="off" />
                            @if(count($karyawanSearchResults) > 0)
                                <ul class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-48 overflow-auto">
                                    @foreach($karyawanSearchResults as $karyawan)
                                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" wire:click="selectKaryawan({{ $karyawan->id }}, '{{ addslashes($karyawan->nama_karyawan) }} ({{ $karyawan->payroll_id }})')">
                                            {{ $karyawan->nama_karyawan }} ({{ $karyawan->payroll_id }})
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                    @error('karyawan_id') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
                
                <!-- Driver Category -->
                <div>
                    <label for="driver_category" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kategori Driver</label>
                    <select id="driver_category" wire:model="driver_category" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        <option value="DUMPTRUCK">DUMPTRUCK</option>
                        <option value="TRAILER">TRAILER</option>
                        <option value="PROJECT">PROJECT</option>
                    </select>
                    @error('driver_category') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- SIM Type -->
                <div>
                    <label for="sim_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipe SIM</label>
                    <input id="sim_type" type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model="sim_type" />
                    @error('sim_type') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
                
                <!-- SIM Expiry Date -->
                <div>
                    <label for="sim_expiry_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Masa Berlaku SIM</label>
                    <input id="sim_expiry_date" type="date" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model="sim_expiry_date" />
                    @error('sim_expiry_date') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
                
                <!-- Status -->
                <div>
                    <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" wire:model="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-button class="ms-3" type="submit">
                    {{ $driver_id ? 'Simpan Perubahan' : 'Simpan' }}
                </x-button>
            </div>
        </form>
    </x-modal>
</div>