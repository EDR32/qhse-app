<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QHSE Public Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js from CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- FOUC Prevention & Initial Theme Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark')
        } else {
          document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => { 
        localStorage.setItem('theme', val ? 'dark' : 'light');
        if (val) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })">

    <div class="relative min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="https://bcs-logistics.co.id/assets/images/logoo.png" alt="BCS Logistics" class="h-8 w-auto">
                        <span class="ml-3 font-semibold text-xl">QHSE Dashboard</span>
                    </div>

                    <!-- Login Button and Dark Mode Toggle -->
                    <div class="flex items-center space-x-4">
                        <button x-on:click="darkMode = !darkMode"
                            class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                            <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h1m-1 0h-1M5.636 5.636l-.707.707M18.364 18.364l.707.707M6.343 17.657l-.707.707M17.657 6.343l.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                        </button>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                               class="rounded-md px-4 py-2 bg-blue-600 text-white font-semibold hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                Log in
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Total Laporan Insiden</h3>
                        <p class="mt-2 text-4xl font-bold">{{ $totalIncidents }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Tindakan Perbaikan Terbuka</h3>
                        <p class="mt-2 text-4xl font-bold">{{ $openActions }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Tindakan Perbaikan Selesai</h3>
                        <p class="mt-2 text-4xl font-bold">{{ $closedActions }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Laporan Observasi Keselamatan</h3>
                        <p class="mt-2 text-4xl font-bold">{{ $safetyObservations }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Tips Keselamatan Hari Ini</h3>
                        <p class="mt-2 text-lg italic text-blue-600 dark:text-blue-400">{{ $randomSafetyTip }}</p>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                    <!-- Incidents per Month Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Laporan Insiden per Bulan (12 Bulan Terakhir)</h3>
                        <canvas id="incidentsChart"></canvas>
                    </div>
                    <!-- Actions by Status Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Komposisi Status Tindakan</h3>
                        <canvas id="actionsStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8 text-center text-sm text-black/50 dark:text-white/70">
            © {{ date('Y') }} BCS Logistics QHSE App. All rights reserved.
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart for Incidents per Month
            const incidentsCtx = document.getElementById('incidentsChart').getContext('2d');
            new Chart(incidentsCtx, {
                type: 'bar',
                data: {
                    labels: @json($incidentLabels),
                    datasets: [{
                        label: 'Jumlah Insiden',
                        data: @json($incidentData),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Chart for Actions by Status
            const actionsStatusCtx = document.getElementById('actionsStatusChart').getContext('2d');
            new Chart(actionsStatusCtx, {
                type: 'pie',
                data: {
                    labels: @json($actionStatusLabels),
                    datasets: [{
                        label: 'Status Tindakan',
                        data: @json($actionStatusData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)', // Open
                            'rgba(54, 162, 235, 0.5)', // Closed
                            'rgba(255, 206, 86, 0.5)', // Continued
                            'rgba(75, 192, 192, 0.5)'  // Other statuses
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>