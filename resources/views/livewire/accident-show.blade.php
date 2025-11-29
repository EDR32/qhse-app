    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Laporan Kecelakaan #' . $accident->id) }}
            </h2>
            <div>
                <a href="{{ route('accidents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Kembali ke Daftar') }}
                </a>
                <a href="{{ route('accidents.edit', $accident) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Edit Laporan') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Deskripsi Kejadian</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $accident->description ?: '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Tindakan Awal</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $accident->initial_action ?: '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Akibat / Konsekuensi</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $accident->consequence ?: '-' }}</p>
                            </div>

                            {{-- Initial Analysis Section --}}
                            @if ($accident->penyebab_dasar || $accident->penjelasan_penyebab_dasar || $accident->penyebab_langsung || $accident->kondisi_tidak_aman || $accident->kesimpulan)
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Hasil Analisis Awal</h3>
                                <div class="space-y-3 text-sm">
                                    <div>
                                        <p class="font-semibold text-gray-600 dark:text-gray-400">Penyebab Dasar:</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $accident->penyebab_dasar ?: '-' }}</p>
                                    </div>
                                    @if($accident->penjelasan_penyebab_dasar)
                                    <div>
                                        <p class="font-semibold text-gray-600 dark:text-gray-400">Penjelasan Penyebab Dasar:</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $accident->penjelasan_penyebab_dasar }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-600 dark:text-gray-400">Penyebab Langsung:</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $accident->penyebab_langsung ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-600 dark:text-gray-400">Kondisi Tidak Aman:</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $accident->kondisi_tidak_aman ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-600 dark:text-gray-400">Kesimpulan:</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $accident->kesimpulan ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($accident->photo_path)
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Foto Kejadian</h3>
                                    <img src="{{ Storage::url($accident->photo_path) }}" alt="Foto Kejadian" class="mt-2 max-w-xs rounded-lg shadow-md">
                                </div>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="font-semibold">Detail Laporan</h4>
                                <dl class="mt-2 space-y-2 text-sm">
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt><dd>{{ $accident->accident_date->format('d F Y') }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Waktu:</dt><dd>{{ $accident->accident_time_range ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Karyawan:</dt><dd>{{ $accident->employee_name }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Kelompok Usia:</dt><dd>{{ $accident->employee_age_group ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Divisi:</dt><dd>{{ $accident->division }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Lokasi:</dt><dd>{{ $accident->location }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">No. Unit:</dt><dd>{{ $accident->unit ? $accident->unit->no_unit : '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Kerugian (Rp):</dt><dd>{{ number_format($accident->financial_loss, 2, ',', '.') ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Hari Kerja Hilang:</dt><dd>{{ $accident->lost_work_days ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Pelapor:</dt><dd>{{ $accident->user->name }}</dd></div>
                                </dl>
                            </div>

                            @if($accident->injured_body_parts || $accident->accident_types)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="font-semibold">Klasifikasi</h4>
                                    <dl class="mt-2 space-y-2 text-sm">
                                        @if($accident->injured_body_parts)
                                            <div><dt class="text-gray-500">Organ Cedera:</dt><dd>{{ implode(', ', $accident->injured_body_parts) }}</dd></div>
                                        @endif
                                        @if($accident->accident_types)
                                            <div><dt class="text-gray-500">Jenis Kecelakaan:</dt><dd>{{ implode(', ', $accident->accident_types) }}</dd></div>
                                        @endif
                                    </dl>
                                </div>
                            @endif

                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="font-semibold">Analisis & Tindak Lanjut</h4>
                                <div class="mt-4">
                                    {{-- This will be the button to create RCA --}}
                                    <a href="{{ route('rca.create', $accident) }}" class="w-full text-center inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Buat Root Cause Analysis (RCA)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>