<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Laporan Driver
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h3 class="text-lg font-semibold mb-4">
                Informasi Driver (Tipe: {{ strtoupper(request('type')) }})
            </h3>

            <div class="space-y-4">

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Payroll ID :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">DATA_PAYROLL_ID</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Nama Driver :</label>
                    <p class="mt-1 text-gray-800 dark:text-gray-100">DATA_NAMA</p>
                </div>

                {{-- BAGIAN INI NANTI KAMU SESUAIKAN PAKAI IF TYPE --}}
                <div class="border-t border-gray-300 dark:border-gray-700 pt-4">
                    <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">Detail Lainnya</h4>

                    <div class="space-y-3">

                        <div>
                            <label class="text-sm font-semibold">Safety Training / Talk :</label>
                            <p class="mt-1">DATA_SAFETY</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold">Tidak Lanjut MCU :</label>
                            <p class="mt-1">DATA_TIDAK_LANJUT_MCU</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold">FGD :</label>
                            <p class="mt-1">DATA_FGD</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold">Fatigue :</label>
                            <p class="mt-1">DATA_FATIGUE</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold">Distraction :</label>
                            <p class="mt-1">DATA_DISTRACTION</p>
                        </div>

                        {{-- Tambah atau kurangi sesuai tipe --}}
                    </div>
                </div>

            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end space-x-3 mt-8">
                <a href="{{ url('violations') }}"
                    class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                           bg-gray-100 dark:bg-gray-700 
                           rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>
