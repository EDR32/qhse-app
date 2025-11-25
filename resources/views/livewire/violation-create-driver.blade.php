{{-- resources/views/violations/create/violation-create-driver.blade.php --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Pelanggaran Driver') }}
        </h2>
    </x-slot>

    @php
        $type = request('type'); // dumptruck | trailer | project
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Info tipe driver --}}
                    <div class="mb-6">
                        <span class="px-4 py-2 rounded bg-blue-100 text-blue-700 text-sm">
                            Tipe Driver: <strong class="uppercase">{{ $type }}</strong>
                        </span>
                    </div>

                    <form>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- PAYROLL ID --}}
                            <div>
                                <x-input-label value="Payroll ID" />
                                <x-text-input type="text" class="block mt-1 w-full" />
                            </div>

                            {{-- Nama --}}
                            <div>
                                <x-input-label value="{{ $type == 'trailer' ? 'Nama' : 'Nama Driver' }}" />
                                <x-text-input type="text" class="block mt-1 w-full" />
                            </div>

                            {{-- ===========================
                                DUMPTRUCK FIELDS
                            ============================ --}}
                            @if ($type == 'dumptruck')

                                <x-input-block label="Safety Training" />
                                <x-input-block label="Tidak Lanjut MCU" />
                                <x-input-block label="FGD (Forum Group Discussion)" />
                                <x-input-block label="Fatigue" />
                                <x-input-block label="Distraction" />
                                <x-input-block label="Field of View" />
                                <x-input-block label="Rest Area Policy" />
                                <x-input-block label="Pelanggaran Jam Larangan" />
                                <x-input-block label="Accident" />
                                <x-input-block label="Violation" />

                            @endif

                            {{-- ===========================
                                TRAILER FIELDS
                            ============================ --}}
                            @if ($type == 'trailer')

                                <x-input-block label="Safety Talk" />
                                <x-input-block label="Tidak Lanjut MCU" />
                                <x-input-block label="FGD (Forum Group Discussion)" />
                                <x-input-block label="Driving Hours" />
                                <x-input-block label="Fatigue" />
                                <x-input-block label="Distraction" />
                                <x-input-block label="Violation" />
                                <x-input-block label="Rest Area Policy" />
                                <x-input-block label="Insiden" />
                                <x-input-block label="Overspeed" />
                                <x-input-block label="Continue Driving" />
                                <x-input-block label="Cell Phone Use" />
                                <x-input-block label="Field of View" />
                                <x-input-block label="In-Cab Assessment" />
                                <x-input-block label="Total Driving" />

                            @endif

                            {{-- ===========================
                                PROJECT FIELDS
                            ============================ --}}
                            @if ($type == 'project')

                                <x-input-block label="Safety Talk" />
                                <x-input-block label="Tidak Lanjut MCU" />
                                <x-input-block label="Rest Area Policy" />
                                <x-input-block label="Pelanggaran Jam Larangan" />
                                <x-input-block label="Accident" />
                                <x-input-block label="Violation" />

                            @endif

                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end space-x-3 mt-8">
                            <a href="{{ url()->previous() }}"
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

                    </form>
                </div>
            </div>
        </div>
    </div>

