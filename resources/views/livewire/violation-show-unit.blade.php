<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Laporan Unit: {{ $unit->no_unit }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h3 class="text-lg font-semibold mb-4">Informasi Unit</h3>

            <div class="space-y-4">

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">No Unit :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->no_unit }}</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Jenis Unit :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->jenis_unit }}</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Kilometer :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">{{ number_format($totalKilometer, 0, ',', '.') }} km</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Storing :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $storingEventCount }} kali</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Accident :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">-</p>
                </div>

            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end space-x-3 mt-8">
                <a href="{{ route('violations.index') }}"
                    class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                           bg-gray-100 dark:bg-gray-700 
                           rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
