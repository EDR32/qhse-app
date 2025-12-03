<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Driver Info Display --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Pelanggaran oleh Driver
                    </h3>
                    <div class="mt-4 space-y-2">
                        <div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Nama Driver:</span>
                            <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $violation->user->karyawan->nama_karyawan ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Payroll ID:</span>
                            <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $violation->user->karyawan->payroll_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Violation Edit Form --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <form wire:submit.prevent="update">
                    <div class="max-w-full">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-2">
                            Edit Detail Pelanggaran
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            {{-- Tanggal Pelanggaran --}}
                            <div>
                                <x-input-label for="violation_date" value="Tanggal Pelanggaran" />
                                <x-text-input type="date" wire:model="violation_date" id="violation_date" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('violation_date')" class="mt-2" />
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <x-input-label for="location" value="Lokasi Kejadian" />
                                <x-text-input type="text" wire:model="location" id="location" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            {{-- Kategori Pelanggaran --}}
                            <div class="col-span-2">
                                <x-input-label for="rule_broken" value="Kategori Pelanggaran" />
                                <select wire:model="rule_broken" id="rule_broken" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-qhse-primary dark:focus:border-qhse-secondary focus:ring-qhse-primary dark:focus:ring-qhse-secondary rounded-md shadow-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($violationCategories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('rule_broken')" class="mt-2" />
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-span-2">
                                <x-input-label for="description" value="Deskripsi Pelanggaran" />
                                <textarea wire:model="description" id="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-qhse-primary dark:focus:border-qhse-secondary focus:ring-qhse-primary dark:focus:ring-qhse-secondary rounded-md shadow-sm" rows="4"></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end space-x-3 mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('violations.show.driver', ['driver' => $violation->user->karyawan->driver->id]) }}" wire:navigate
                                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                                    bg-gray-100 dark:bg-gray-700 
                                    rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 
                                    transition">
                                Batal
                            </a>

                            <x-primary-button>
                                Simpan Perubahan
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>