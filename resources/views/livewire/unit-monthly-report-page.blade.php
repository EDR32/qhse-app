
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Bulanan Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Message Banners --}}
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif
             @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Filters --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Pilih Unit') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Anda sedang melihat unit untuk kategori: <span class="font-semibold">{{ ucfirst($kategori) }}</span>
                    </p>
                    <div class="mt-4">
                        {{-- Unit Filter --}}
                        <div>
                            <x-input-label for="selectedUnitId" :value="__('Nomor Unit')" />
                            <select id="selectedUnitId" wire:model.live="selectedUnitId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" {{ count($units) === 0 ? 'disabled' : '' }}>
                                <option value="">-- Pilih Nomor Unit --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->no_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Report Details --}}
            @if($report)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Detail Laporan: ' . ($report->unit->no_unit ?? 'N/A') . ' - ' . \Carbon\Carbon::create()->month($report->month)->monthName . ' ' . $report->year) }}</h3>

                    {{-- Kilometer Section --}}
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Kinerja Jarak Tempuh') }}</h4>
                        <div class="mt-4 max-w-xl">
                            <x-input-label for="kilometer" :value="__('Total Kilometer Bulan Ini (KM)')" />
                            <div class="flex items-center space-x-2">
                                <x-text-input id="kilometer" type="number" step="0.01" class="mt-1 block w-full" wire:model="kilometer" />
                                <x-primary-button type="button" wire:click.prevent="saveKilometer">{{ __('Simpan') }}</x-primary-button>
                            </div>
                             <x-input-error :messages="$errors->get('kilometer')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Storing Events Section --}}
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                         <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Temuan Storing') }}</h4>

                        <div x-data="{ activeTab: @entangle('activeTab') }" class="mt-4">
                            <!-- Tabs -->
                            <div class="border-b border-gray-200 dark:border-gray-700">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button @click.prevent="activeTab = 'minggu1'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'minggu1', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'minggu1'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Minggu 1</button>
                                    <button @click.prevent="activeTab = 'minggu2'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'minggu2', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'minggu2'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Minggu 2</button>
                                    <button @click.prevent="activeTab = 'minggu3'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'minggu3', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'minggu3'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Minggu 3</button>
                                    <button @click.prevent="activeTab = 'minggu4'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'minggu4', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'minggu4'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Minggu 4</button>
                                    <button @click.prevent="activeTab = 'minggu5'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'minggu5', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'minggu5'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Minggu 5</button>
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            @for ($week = 1; $week <= 5; $week++)
                            <div x-show="activeTab === 'minggu{{ $week }}'" class="mt-4 space-y-4">
                                {{-- Display existing storing events --}}
                                @foreach ($storingEvents->where('week_of_month', $week) as $event)
                                <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</p>
                                    <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $event->description }}</p>
                                </div>
                                @endforeach
                            </div>
                            @endfor
                        </div>

                        {{-- Add New Storing Event Form --}}
                        <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                             <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Tambah Temuan Storing Baru') }}</h4>
                             <form wire:submit.prevent="addStoringEvent" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="newStoring.driver" :value="__('Nama / Payroll ID Driver')" />
                                    <x-text-input id="newStoring.driver" type="text" class="mt-1 block w-full" wire:model="newStoring.driver" placeholder="Masukkan nama atau Payroll ID Driver (Min. 2 Huruf)" />
                                    <x-input-error :messages="$errors->get('newStoring.driver')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="newStoring.event_date" :value="__('Tanggal Kejadian')" />
                                    <x-text-input id="newStoring.event_date" type="date" class="mt-1 block w-full" wire:model="newStoring.event_date" />
                                    <x-input-error :messages="$errors->get('newStoring.event_date')" class="mt-2" />
                                </div>
                                 <div>
                                    <x-input-label for="newStoring.event_time" :value="__('Waktu Kejadian')" />
                                    <x-text-input id="newStoring.event_time" type="time" class="mt-1 block w-full" wire:model="newStoring.event_time" />
                                    <x-input-error :messages="$errors->get('newStoring.event_time')" class="mt-2" />
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="newStoring.location" :value="__('Lokasi')" />
                                    <x-text-input id="newStoring.location" type="text" class="mt-1 block w-full" wire:model="newStoring.location" />
                                    <x-input-error :messages="$errors->get('newStoring.location')" class="mt-2" />
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="newStoring.description" :value="__('Deskripsi')" />
                                    <textarea id="newStoring.description" wire:model="newStoring.description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    <x-input-error :messages="$errors->get('newStoring.description')" class="mt-2" />
                                </div>
                                <div class="col-span-1 md:col-span-2 flex justify-end">
                                    <x-primary-button type="submit">{{ __('Tambah Temuan') }}</x-primary-button>
                                </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

