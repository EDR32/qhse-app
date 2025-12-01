<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Pelanggaran Driver') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Driver Selection Card --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Pilih Driver') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Anda sedang menambah pelanggaran untuk kategori: <span class="font-semibold">{{ $displayDriverType }}</span>
                    </p>
                    
                    <div class="mt-4">
                        <x-input-label for="driver_search" value="Nama / Payroll ID Driver" />
                        @if ($selectedKaryawanName)
                            <div class="mt-2 flex items-center justify-between p-3 bg-gray-100 dark:bg-qhse-neutral-light rounded-md border border-gray-300 dark:border-gray-600">
                                <span class="text-gray-800 dark:text-white font-semibold">{{ $selectedKaryawanName }}</span>
                                <button type="button" wire:click="changeKaryawan" class="text-sm text-red-500 hover:text-red-700 font-semibold">Ganti</button>
                            </div>
                        @else
                            <div class="relative mt-1">
                                <x-text-input type="text"
                                    wire:model.live.debounce.300ms="driver_search"
                                    class="block w-full"
                                    placeholder="Ketik nama atau payroll ID (min. 2 huruf)..." />
                                
                                @if(count($searchResults) > 0)
                                    <div class="absolute z-10 w-full mt-1 bg-white dark:bg-qhse-neutral-light rounded-md shadow-lg">
                                        <ul class="max-h-60 overflow-auto rounded-md py-1 text-base leading-6 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            @foreach($searchResults as $result)
                                                <li wire:click="selectKaryawan({{ $result->id }})" class="cursor-pointer select-none relative py-2 pl-3 pr-9 text-gray-900 dark:text-white hover:bg-qhse-secondary hover:dark:bg-qhse-secondary-dark">
                                                    <span class="font-normal block truncate">{{ $result->nama_karyawan }} ({{ $result->payroll_id }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('karyawan_id')" class="mt-2" />
                        <x-input-error :messages="$errors->get('driver_type')" class="mt-2" />
                        <x-input-error :messages="$errors->get('driver_search')" class="mt-2" />
                    </div>
                </div>
            </div>
            
            {{-- Violation Details Section (Visible only after driver is selected) --}}
            @if($karyawan_id)
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <form wire:submit.prevent="save">
                    <div class="max-w-full">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-2">
                            Isi Detail Pelanggaran
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
                                <x-input-label for="violation_category" value="Kategori Pelanggaran" />
                                <select wire:model="violation_category" id="violation_category" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-qhse-primary dark:focus:border-qhse-secondary focus:ring-qhse-primary dark:focus:ring-qhse-secondary rounded-md shadow-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($violationCategories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('violation_category')" class="mt-2" />
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-span-2">
                                <x-input-label for="description" value="Deskripsi Pelanggaran" />
                                <textarea wire:model="description" id="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-qhse-primary dark:focus:border-qhse-secondary focus:ring-qhse-primary dark:focus:ring-qhse-secondary rounded-md shadow-sm" rows="4"></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Sanksi --}}
                            <div class="col-span-2">
                                <x-input-label for="sanction" value="Sanksi yang Diberikan (Opsional)" />
                                <textarea wire:model="sanction" id="sanction" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-qhse-primary dark:focus:border-qhse-secondary focus:ring-qhse-primary dark:focus:ring-qhse-secondary rounded-md shadow-sm" rows="2"></textarea>
                                <x-input-error :messages="$errors->get('sanction')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end space-x-3 mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('violations.index') }}" wire:navigate
                                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                                    bg-gray-100 dark:bg-gray-700 
                                    rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 
                                    transition">
                                Batal
                            </a>

                            <x-primary-button>
                                Simpan
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>