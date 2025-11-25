<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tambah Data Unit') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <!-- FORM START -->
                <form>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- No Unit -->
                        <div>
                            <x-input-label for="no_unit" :value="__('No Unit')" />
                            <x-text-input
                                id="no_unit"
                                class="block mt-1 w-full"
                                type="text"
                                name="no_unit"
                                placeholder="Masukkan nomor unit"
                            />
                        </div>

                        <!-- Jenis Unit -->
                        <div>
                            <x-input-label for="jenis_unit" :value="__('Jenis Unit')" />
                            <x-text-input
                                id="jenis_unit"
                                class="block mt-1 w-full"
                                type="text"
                                name="jenis_unit"
                                placeholder="Contoh: Dumptruck, Trailer"
                            />
                        </div>

                        <!-- Kilometer -->
                        <div>
                            <x-input-label for="kilometer" :value="__('Kilometer')" />
                            <x-text-input
                                id="kilometer"
                                class="block mt-1 w-full"
                                type="number"
                                name="kilometer"
                                placeholder="Masukkan kilometer unit"
                            />
                        </div>

                        <!-- Storing -->
                        <div>
                            <x-input-label for="storing" :value="__('Storing')" />
                            <textarea
                                id="storing"
                                name="storing"
                                rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 
                                       dark:focus:border-indigo-600 focus:ring-indigo-500 
                                       dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Catatan storing atau kerusakan unit"
                            ></textarea>
                        </div>

                        <!-- Accident -->
                        <div class="md:col-span-2">
                            <x-input-label for="accident" :value="__('Accident')" />
                            <textarea
                                id="accident"
                                name="accident"
                                rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 
                                       dark:focus:border-indigo-600 focus:ring-indigo-500 
                                       dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Riwayat kecelakaan (jika ada)"
                            ></textarea>
                        </div>

                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="flex items-center justify-end mt-6">
                        <a href="#"
                           class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 
                                  dark:hover:text-white rounded-md focus:outline-none 
                                  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                  dark:focus:ring-offset-gray-800">
                            {{ __('Batal') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>

                </form>
                <!-- FORM END -->

            </div>
        </div>
    </div>
</div>
