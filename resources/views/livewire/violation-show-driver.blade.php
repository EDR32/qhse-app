<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pelanggaran Driver
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Driver Information Card --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Informasi Driver
                    </h3>
                    <div class="mt-4 space-y-2">
                        <div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Nama Driver:</span>
                            <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $driver->karyawan->nama_karyawan ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Payroll ID:</span>
                            <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $driver->karyawan->payroll_id ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Kategori:</span>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $driver->driver_category }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Violations Table --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-qhse-neutral-dark shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Riwayat Pelanggaran
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori Pelanggaran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($violations as $index => $violation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $violations->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($violation->violation_date)->isoFormat('D MMM YYYY') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $violation->rule_broken }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $violation->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('violations.edit', $violation) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada riwayat pelanggaran untuk driver ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-4">
                    {{ $violations->links() }}
                </div>
            </div>

            <div class="flex items-center justify-start mt-6">
                <a href="{{ route('violations.index') }}"
                    class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                           bg-gray-200 dark:bg-gray-600 
                           rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                    &larr; Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>