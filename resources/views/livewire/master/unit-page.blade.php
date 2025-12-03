<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Daftar Unit
                    </h3>
                    <div class="flex space-x-4">
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari unit..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full sm:w-64" />
                        <x-button wire:click="create()">
                            {{ __('Tambah Unit') }}
                        </x-button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nomor Unit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis Unit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($units as $unit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $unit->no_unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $unit->jenis_unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $unit->kategori }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <x-button wire:click="edit({{ $unit->id }})">
                                            Edit
                                        </x-button>
                                        <x-danger-button wire:click="delete({{ $unit->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?">
                                            Delete
                                        </x-danger-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300">
                                        Tidak ada data unit yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $units->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-modal name="unit-form-modal" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $unit_id ? 'Edit Unit' : 'Tambah Unit Baru' }}
            </h2>

            <div class="mt-6 space-y-4">
                <div>
                    <label for="no_unit" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Nomor Unit') }}</label>
                    <input id="no_unit" type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model="no_unit" />
                    @error('no_unit') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="jenis_unit" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Jenis Unit') }}</label>
                    <input id="jenis_unit" type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model="jenis_unit" />
                    @error('jenis_unit') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="kategori" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Kategori') }}</label>
                    <input id="kategori" type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" wire:model="kategori" />
                    @error('kategori') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-button class="ms-3" type="submit">
                    {{ $unit_id ? 'Simpan Perubahan' : 'Simpan' }}
                </x-button>
            </div>
        </form>
    </x-modal>
</div>