<nav x-data="{ open: false }" class="bg-qhse-neutral-light dark:bg-qhse-neutral-dark border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="text-xl font-semibold text-qhse-primary dark:text-qhse-secondary">
                            QHSE App
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Manajemen Insiden Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-qhse-neutral-dark dark:text-qhse-neutral-light bg-qhse-neutral-light dark:bg-qhse-neutral-dark hover:text-qhse-primary dark:hover:text-qhse-secondary focus:outline-none transition ease-in-out duration-150">
                                    <div>Manajemen Insiden</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('accidents.index')">
                                    {{ __('Accidents') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('violations.index')">
                                    {{ __('Pelanggaran') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('rca.index')">
                                    {{ __('Root Cause Analysis') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cars.index')">
                                    {{ __('Corrective Actions (CAR)') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Manajemen Risiko Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="w-max" contentClasses="p-4 bg-white dark:bg-qhse-neutral-dark">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-qhse-neutral-dark dark:text-qhse-neutral-light bg-qhse-neutral-light dark:bg-qhse-neutral-dark hover:text-qhse-primary dark:hover:text-qhse-secondary focus:outline-none transition ease-in-out duration-150">
                                    <div>Manajemen Risiko</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="grid grid-cols-3 gap-4">
                                    <a href="{{ route('manajemen-risiko.training') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('Training') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.fgd') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('FGD') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.inspection') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('Inspection') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.safety-patrol') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('Safety Patrol') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.safety-observation-tour') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out whitespace-nowrap">
                                        {{ __('Safety Observation Tour') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.capa') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('CAPA') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.nearmiss-report') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('Nearmiss Report') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.audit-report') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('Audit Report') }}
                                    </a>
                                    <a href="{{ route('manajemen-risiko.apd') }}" class="block px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ __('APD') }}
                                    </a>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- @can('view all incidents')
                        <x-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                            Insiden
                        </x-nav-link>
                    @endcan
                    @can('manage actions')
                        <x-nav-link :href="route('actions.index')" :active="request()->routeIs('actions.*')">
                            Tindakan (CAPA)
                        </x-nav-link>
                    @endcan
                    @can('view all audits')
                        <x-nav-link :href="route('audits.index')" :active="request()->routeIs('audits.*')">
                            Audit & Inspeksi
                        </x-nav-link>
                    @endcan --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-qhse-neutral-dark dark:text-qhse-neutral-light bg-qhse-neutral-light dark:bg-qhse-neutral-dark hover:text-qhse-primary dark:hover:text-qhse-secondary focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- @can('view all incidents')
                <x-responsive-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                    Insiden
                </x-responsive-nav-link>
            @endcan
            @can('manage actions')
                <x-responsive-nav-link :href="route('actions.index')" :active="request()->routeIs('actions.*')">
                    Tindakan (CAPA)
                </x-responsive-nav-link>
            @endcan
            @can('view all audits')
                <x-responsive-nav-link :href="route('audits.index')" :active="request()->routeIs('audits.*')">
                    Audit & Inspeksi
                </x-responsive-nav-link>
            @endcan --}}

            <!-- Responsive Manajemen Insiden Links -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">Manajemen Insiden</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('accidents.index')">
                        {{ __('Accidents') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('violations.index')">
                        {{ __('Pelanggaran') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('rca.index')">
                        {{ __('Root Cause Analysis') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cars.index')">
                        {{ __('Corrective Actions (CAR)') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Manajemen Risiko Links -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">Manajemen Risiko</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('manajemen-risiko.training')">
                        {{ __('Training') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.fgd')">
                        {{ __('FGD (Forum Group Discussion)') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.inspection')">
                        {{ __('Inspection') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.safety-patrol')">
                        {{ __('Safety Patrol') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.safety-observation-tour')">
                        {{ __('Safety Observation Tour') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.capa')">
                        {{ __('CAPA') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.nearmiss-report')">
                        {{ __('Nearmiss Report') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.audit-report')">
                        {{ __('Audit Report') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('manajemen-risiko.apd')">
                        {{ __('APD') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
