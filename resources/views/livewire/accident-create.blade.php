    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Laporan Kecelakaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                                        <form wire:submit.prevent="save">
                                            @if (!$userSelected)
                                                <!-- STEP 1: User Selection -->
                                                <div class="max-w-md mx-auto min-h-[23rem]">
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Langkah 1: Pilih Karyawan</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Mulai dengan mencari nama atau NIK karyawan yang terlibat dalam kecelakaan.</p>
                    
                                                    <div class="relative">
                                                        <x-input-label for="employee_name_search" :value="__('Cari Nama / Payroll ID')" />
                                                        <x-text-input wire:model.live.debounce.100ms="employee_name" id="employee_name_search" class="block mt-1 w-full" type="text" name="employee_name_search" autocomplete="off" placeholder="Ketik untuk mencari..." required />
                                                        @error('employee_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                                                        @if(!empty($userSearchResults) && strlen($employee_name) >= 1)
                                                            <div class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg mt-1 max-h-96 overflow-y-auto">
                                                                @foreach($userSearchResults as $user)
                                                                    <div wire:key="{{ $user->payroll_id }}" wire:click="selectUser('{{ $user->payroll_id }}')" class="p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 flex justify-between items-center">
                                                                        <span>{{ $user->nama_karyawan }}</span>
                                                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $user->payroll_id }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <!-- STEP 2: Form Details -->
                                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Langkah 2: Isi Detail Laporan</h3>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            Laporan untuk: <span class="font-semibold">{{ $employee_name }} (Payroll ID: {{ $employee_payroll_id }})</span>
                                                        </p>
                                                        <button type="button" wire:click="changeUser" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Ganti Karyawan</button>
                                                    </div>
                                                </div>
                    
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Section: Employee Data -->
                                <div class="md:col-span-2">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Data Karyawan</h4>
                                    <hr class="mt-1 mb-4 border-gray-300 dark:border-gray-600">
                                </div>

                                <div>
                                    <x-input-label for="employee_payroll_id" :value="__('Payroll ID')" />
                                    <x-text-input wire:model="employee_payroll_id" id="employee_payroll_id" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" name="employee_payroll_id" readonly />
                                    @error('employee_payroll_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-input-label for="employee_name" :value="__('Nama Karyawan')" />
                                    <x-text-input wire:model="employee_name" id="employee_name" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" name="employee_name" readonly />
                                </div>

                                <div>
                                    <x-input-label for="division" :value="__('Divisi')" />
                                    <x-text-input wire:model="division" id="division" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" name="division" readonly />
                                    @error('division') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-input-label for="employee_age_group" :value="__('Usia')" />
                                    <x-text-input wire:model="employee_age_group" id="employee_age_group" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" name="employee_age_group" readonly />
                                    @error('employee_age_group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Section: Incident Details -->
                                <div class="md:col-span-2 mt-6">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Detail Kejadian</h4>
                                    <hr class="mt-1 mb-4 border-gray-300 dark:border-gray-600">
                                </div>

                                <div>
                                    <x-input-label for="location" :value="__('Lokasi Kejadian')" />
                                    <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" name="location" required />
                                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-input-label for="accident_date" :value="__('Tanggal Kejadian')" />
                                    <x-text-input wire:model="accident_date" id="accident_date" class="block mt-1 w-full" type="date" name="accident_date" required />
                                    @error('accident_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <x-input-label for="accident_time_range" :value="__('Waktu Terjadi (WIB)')" />
                                    <x-text-input wire:model="accident_time_range" id="accident_time_range" class="block mt-1 w-full" type="text" name="accident_time_range" placeholder="Contoh: 06.01 - 12.00" />
                                    @error('accident_time_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-input-label for="equipment_type" :value="__('Jenis Alat / Unit')" />
                                    <x-text-input wire:model="equipment_type" id="equipment_type" class="block mt-1 w-full" type="text" name="equipment_type" />
                                    @error('equipment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Deskripsi Kejadian')" />
                                    <textarea wire:model="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="initial_action" :value="__('Tindakan Awal yang Dilakukan')" />
                                    <textarea wire:model="initial_action" id="initial_action" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('initial_action') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="consequence" :value="__('Akibat / Konsekuensi dari Kejadian')" />
                                    <textarea wire:model="consequence" id="consequence" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('consequence') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Section: Accident Analysis -->
                                <div class="md:col-span-2 mt-6">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Analisis Kecelakaan</h4>
                                    <hr class="mt-1 mb-4 border-gray-300 dark:border-gray-600">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <x-input-label for="penyebab_dasar" :value="__('Penyebab Dasar')" />
                                    <select wire:model.live="penyebab_dasar" id="penyebab_dasar" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">-- Pilih Penyebab --</option>
                                        <option value="Manusia">Manusia</option>
                                        <option value="Alat">Alat</option>
                                        <option value="Material">Material</option>
                                        <option value="Metode">Metode</option>
                                        <option value="Lingkungan">Lingkungan</option>
                                    </select>
                                    @error('penyebab_dasar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                @if($penyebab_dasar)
                                <div class="md:col-span-2">
                                    <x-input-label for="penjelasan_penyebab_dasar" :value="__('Penjelasan Penyebab Dasar')" />
                                    <textarea wire:model="penjelasan_penyebab_dasar" id="penjelasan_penyebab_dasar" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('penjelasan_penyebab_dasar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                @endif

                                <div class="md:col-span-2">
                                    <x-input-label for="penyebab_langsung" :value="__('Penyebab Langsung')" />
                                    <textarea wire:model="penyebab_langsung" id="penyebab_langsung" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('penyebab_langsung') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="kondisi_tidak_aman" :value="__('Kondisi yang Tidak Aman')" />
                                    <textarea wire:model="kondisi_tidak_aman" id="kondisi_tidak_aman" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('kondisi_tidak_aman') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="kesimpulan" :value="__('Kesimpulan')" />
                                    <textarea wire:model="kesimpulan" id="kesimpulan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('kesimpulan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Section: Impact & Classification -->
                                <div class="md:col-span-2 mt-6">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Dampak & Klasifikasi</h4>
                                    <hr class="mt-1 mb-4 border-gray-300 dark:border-gray-600">
                                </div>

                                <div class="md:col-span-2">
                                    <fieldset class="border border-gray-300 dark:border-gray-600 p-4 rounded-md">
                                        <legend class="text-sm font-medium text-gray-700 dark:text-gray-300 px-2">{{ __('Detail Kerugian Finansial') }}</legend>
                                        <div class="space-y-4">
                                            @foreach ($loss_categories as $category => $checked)
                                                <div class="relative">
                                                    <label for="loss_category_{{ $category }}" class="flex items-center">
                                                        <input id="loss_category_{{ $category }}" type="checkbox" wire:model.live="loss_categories.{{ $category }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                        <span class="ms-3 text-sm text-gray-600 dark:text-gray-400">{{ $category }}</span>
                                                    </label>
                                                    @if ($checked)
                                                        <div class="mt-2 ms-7">
                                                            <x-input-label for="loss_amount_{{ $category }}" :value="__('Jumlah (Rp)')" class="sr-only" />
                                                            <x-text-input type="number" wire:model.live.debounce.300ms="loss_amounts.{{ $category }}" id="loss_amount_{{ $category }}" class="block w-full sm:w-1/2" placeholder="Masukkan jumlah" />
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <hr class="border-gray-300 dark:border-gray-600">
                                            <!-- Total Financial Loss -->
                                            <div>
                                                <x-input-label for="financial_loss" :value="__('Total Estimasi Kerugian (Rp)')" />
                                                <x-text-input id="financial_loss" class="block mt-1 w-full sm:w-1/2 bg-gray-100 dark:bg-gray-700" type="text" readonly value="{{ number_format($financial_loss ?? 0, 0, ',', '.') }}" />
                                            </div>
                                        </div>
                                    </fieldset>
                                    @error('financial_loss') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Bagian Organ Tubuh Cedera')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @php
                                            $bodyParts = ['Kepala', 'Mata', 'Telinga', 'Lengan', 'Tangan', 'Jari Tangan', 'Paha', 'Kaki', 'Jari Kaki', 'Organ Tubuh Bagian Dalam'];
                                        @endphp
                                        @foreach($bodyParts as $part)
                                            <label for="injured_body_parts_{{ Str::slug($part) }}" class="flex items-center">
                                                <input type="checkbox" wire:model="injured_body_parts" id="injured_body_parts_{{ Str::slug($part) }}" value="{{ $part }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $part }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('injured_body_parts') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Jenis Kecelakaan')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @php
                                            $accidentTypes = ['Fatality', 'LTI', 'MTI', 'WI', 'PD', 'Fire Case'];
                                        @endphp
                                        @foreach($accidentTypes as $type)
                                            <label for="accident_types_{{ Str::slug($type) }}" class="flex items-center">
                                                <input type="checkbox" wire:model="accident_types" id="accident_types_{{ Str::slug($type) }}" value="{{ $type }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $type }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('accident_types') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <x-input-label for="lost_work_days" :value="__('Jumlah Hari Kerja Hilang (Hari)')" />
                                    <x-text-input wire:model="lost_work_days" id="lost_work_days" class="block mt-1 w-full" type="number" name="lost_work_days" />
                                    @error('lost_work_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Section: Attachments -->
                                <div class="md:col-span-2 mt-6">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Lampiran</h4>
                                    <hr class="mt-1 mb-4 border-gray-300 dark:border-gray-600">
                                </div>

                                <div>
                                    <x-input-label for="photo_path" :value="__('Foto Kejadian')" />
                                    <input type="file" wire:model="photo_path" id="photo_path" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                    @error('photo_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @if ($photo_path)
                                        <img src="{{ $photo_path->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded-md">
                                    @endif
                                </div>
                            </div>
                                            @endif
                    
                                            <div class="flex items-center justify-end mt-6">
                                                <a href="{{ route('accidents.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Batal') }}
                                                </a>
                                                
                                                @if ($userSelected)
                                                    <x-primary-button class="ms-4">
                                                        {{ __('Simpan') }}
                                                    </x-primary-button>
                                                @endif
                                            </div>
                                        </form>                </div>
            </div>
        </div>
    </div>
