<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Laporan Unit: {{ $unit->no_unit }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto space-y-6">

            <!-- Unit Info Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Informasi Unit</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">No Unit:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->no_unit }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Jenis Unit:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->jenis_unit }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Total Kilometer:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ number_format($totalKilometer, 0, ',', '.') }} km</p>
                    </div>
                    <div>
                        <button 
                            wire:click.prevent="openStoringModal" 
                            @disabled($storingEventCount === 0)
                            class="w-full flex justify-between items-center text-left py-1 disabled:opacity-50 disabled:cursor-not-allowed group"
                        >
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Total Storing:</span>
                            <span class="text-blue-600 dark:text-blue-400 group-hover:underline group-disabled:no-underline group-disabled:text-gray-800 dark:group-disabled:text-gray-100">
                                {{ $storingEventCount }} kali
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Accident History Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Riwayat Kecelakaan</h3>
                <div class="space-y-4">
                    @forelse ($accidents as $accident)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $accident->accident_date->format('d F Y') }}
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200">
                                        {{ Str::limit($accident->description, 150) }}
                                    </p>
                                </div>
                                <a href="{{ route('accidents.show', $accident) }}" class="ms-4 px-3 py-1 text-sm text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/50 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-900 transition-colors whitespace-nowrap">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada riwayat kecelakaan untuk unit ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end">
                <a href="{{ route('violations.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 
                           bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 
                           rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Storing Details Modal --}}
    <x-modal name="storing-details">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Detail Riwayat Storing untuk Unit {{ $unit->no_unit }}
            </h2>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Waktu</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Driver</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Lokasi</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($storingEvents as $event)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Nama Driver</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $event->location }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $event->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada data storing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Tutup
                </x-secondary-button>
            </div>
        </div>
    </x-modal>
</div>
