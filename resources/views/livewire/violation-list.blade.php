<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Laporan Pelanggaran (Violation)') }}
        </h2>
    </div>
</x-slot>

<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- SELECT LAPORAN BARU --}}
        <div x-data="{
                showSelect: true,
                jenis: '',
                tipe: '',
                routes: {
                    unit: {
                        bulk: '{{ route('violations.create.unit', ['type' => 'bulk']) }}',
                        dumptruck: '{{ route('violations.create.unit', ['type' => 'dumptruck']) }}',
                        transport: '{{ route('violations.create.unit', ['type' => 'transport']) }}',
                    },
                    driver: {
                        dumptruck: '{{ route('violations.create.driver', ['driver_type' => 'dumptruck']) }}',
                        trailer: '{{ route('violations.create.driver', ['driver_type' => 'trailer']) }}',
                        project: '{{ route('violations.create.driver', ['driver_type' => 'project']) }}',
                    }
                }
            }" 
            class="space-y-4 mb-6">

            <!-- SELECT JENIS -->
            <div x-show="showSelect" x-transition.opacity class="max-w-sm">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Buat Laporan Baru
                </label>

                <select x-model="jenis"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 
                        dark:bg-gray-800 dark:text-white rounded-lg shadow-sm p-2.5
                        focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Jenis Laporan --</option>
                    <option value="unit">Laporan Unit</option>
                    <option value="driver">Laporan Driver</option>
                </select>
            </div>

            <!-- SELECT TIPE -->
            <div x-show="jenis !== ''" x-transition.opacity class="max-w-sm mt-4">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Pilih Tipe untuk <span x-text="jenis.toUpperCase()"></span>
                </label>

                <select 
                    x-model="tipe"
                    @change="if (tipe) window.location = routes[jenis][tipe]"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 
                        dark:bg-gray-800 dark:text-white rounded-lg shadow-sm p-2.5
                        focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Tipe --</option>

                    <!-- UNIT -->
                    <option value="bulk" x-show="jenis === 'unit'">Bulk</option>
                    <option value="dumptruck" x-show="jenis === 'unit'">Dumptruck</option>
                    <option value="transport" x-show="jenis === 'unit'">Transport</option>

                    <!-- DRIVER -->
                    <option value="dumptruck" x-show="jenis === 'driver'">Dumptruck</option>
                    <option value="trailer" x-show="jenis === 'driver'">Trailer</option>
                    <option value="project" x-show="jenis === 'driver'">Project</option>

                </select>
            </div>

        </div>

        {{-- TABLE LIST --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
            {{-- TABEL UNIT (KIRI) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Data Unit</h2>
                    </div>
                    <div class="mb-4">
                        <x-text-input wire:model.live.debounce.300ms="unitSearch" class="block w-full" type="search" placeholder="Cari No Unit..." />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">No Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Jenis Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($units as $index => $unit)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $units->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $unit->no_unit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $unit->jenis_unit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('violations.show.unit', $unit) }}" class="text-blue-600 hover:underline">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada data unit.
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

            {{-- TABEL DRIVER (KANAN) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Data Driver</h2>
                    </div>
                    <div class="mb-4">
                        <x-text-input wire:model.live.debounce.300ms="driverSearch" class="block w-full" type="search" placeholder="Cari Driver/Kategori..." />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Payroll ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Nama Driver</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($drivers as $index => $driver)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $drivers->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $driver->karyawan->payroll_id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $driver->karyawan->nama_karyawan ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $driver->driver_category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Assuming a route violations.show.driver exists that accepts a Driver model --}}
                                            <a href="{{ route('violations.show.driver', $driver) }}" class="text-blue-600 hover:underline">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada data driver.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>