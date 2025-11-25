<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Laporan Pelanggaran (Violation)') }}
        </h2>
    </div>
</x-slot>

<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol Utama
                <button @click="open = !open"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md 
                    font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 
                    active:bg-blue-700 focus:outline-none transition">
                    Buat Laporan Baru
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button> --}}
                
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
                        dumptruck: '{{ route('violations.create.driver', ['type' => 'dumptruck']) }}',
                        trailer: '{{ route('violations.create.driver', ['type' => 'trailer']) }}',
                        project: '{{ route('violations.create.driver', ['type' => 'project']) }}',
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
                    <h2 class="text-lg font-semibold mb-4">Data Unit</h2>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">No Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Jenis Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data Unit masuk dari Livewire --}}
                            <tr>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">1</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">2</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">3</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">
                                    <a href="{{ url('violations/unit') }}" class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TABEL DRIVER (KANAN) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-semibold mb-4">Data Driver</h2>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Payroll ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Nama Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data Driver masuk dari Livewire --}}
                            <tr>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">1</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">2</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">3</td>
                                <td class="border border-gray-200 dark:border-gray-700 px-6 py-3 text-left text-xs font-medium">
                                    <a href="{{ url('violations/driver') }}" class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    </div>
</div>
