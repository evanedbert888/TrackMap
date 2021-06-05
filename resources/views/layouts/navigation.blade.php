<script>
    const sidebarHandler = (check) => {
        if (check) {
            document.getElementById("slidebar").style.transform = "translateX(0px)";
            document.getElementById("menu").classList.add("mr-48");
            document.getElementById("closeSideBar").classList.remove("hidden");
        } else {
            document.getElementById("slidebar").style.transform = "translateX(-100%)";
            document.getElementById("menu").classList.remove("mr-48");
            document.getElementById("closeSideBar").classList.add("hidden");
        }
    };
    function dropdownHandler(element) {
        let single = element.getElementsByTagName("ul")[0];
        single.classList.toggle("hidden");
    }
</script>
<!-- Primary Navigation Menu -->
<div class="w-full h-full">
    <div class="flex flex-no-wrap">
        <div class="w-full h-full">
            <div class="flex flex-no-wrap">
                <!-- Sidebar starts -->
                <div id="slidebar" class="absolute bg-white shadow h-screen flex-col justify-between transform -translate-x-full z-40 transition duration-500">
                    <div class="px-8">
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="navbar-brand">
                                <x-application-logo />
                            </a>
                        </div>
                        <ul class="mt-8">
                            <li class="flex w-full justify-between text-indigo-700 cursor-pointer items-center mb-6">
                                <div class="flex items-center">
                                    <div class="sm:flex">
                                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                            {{ __('Dashboard') }}
                                        </x-nav-link>
                                    </div>
                                </div>
                            </li>
                            @if(Auth::user()->role == 'admin')
                                <li class="flex w-full justify-between text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <div class="sm:flex">
                                            <x-nav-link :href="route('show_user')" :active="request()->routeIs('show_user')">
                                                {{ __('User') }}
                                            </x-nav-link>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                <div class="flex items-center">
                                    <div class="sm:flex sm:items-center">
                                        <x-dropdown width="48">
                                            <x-slot name="trigger">
                                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                    @if(Auth::user()->role == 'admin')
                                                        <div>{{ 'Company' }}</div>
                                                    @elseif(Auth::user()->role == 'employee')
                                                        <div>{{ 'Destination' }}</div>
                                                    @endif
                                                    <div class="ml-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('company_list')">
                                                    @if(Auth::user()->role == 'admin')
                                                        {{ __('Company List') }}
                                                    @elseif(Auth::user()->role == 'employee')
                                                        {{ __('Destination List') }}
                                                    @endif
                                                </x-dropdown-link>
                                                @if(Auth::user()->role == 'admin')
                                                    <x-dropdown-link :href="route('company_form')">
                                                        {{ __('Add Company') }}
                                                    </x-dropdown-link>
                                                @elseif(Auth::user()->role == 'employee')
                                                    <x-dropdown-link :href="route('task_list')">
                                                        {{ __('Task List') }}
                                                    </x-dropdown-link>
                                                @endif
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </div>
                            </li>

                            @if(Auth::user()->role == 'admin')
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <div class="sm:flex sm:items-center">
                                            <x-dropdown width="48">
                                                <x-slot name="trigger">
                                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                        <div>{{ 'Employee' }}</div>

                                                        <div class="ml-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('employee_list')">
                                                        {{ __('Employee List') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link :href="route('email_register')">
                                                        {{ __('Email Register') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link :href="route('register_list')">
                                                        {{ __('Register List') }}
                                                    </x-dropdown-link>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <div class="space-x-8 sm:-my-px sm:flex">
                                            <x-nav-link :href="route('task_pairing')" :active="request()->routeIs('task_pairing')">
                                                {{ __('Task') }}
                                            </x-nav-link>
                                        </div>
                                    </div>
                                </li>
                            @elseif(Auth::user()->role == 'employee')
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <div class="space-x-8 sm:-my-px sm:flex">
                                            <x-nav-link :href="route('history')" :active="request()->routeIs('history')">
                                                {{ __('History') }}
                                            </x-nav-link>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Sidebar ends -->
                <div class="w-full">
                    <div class="bg-gray-800 opacity-50 w-full h-full absolute hidden" id="closeSideBar" onclick="sidebarHandler(false)"></div>
                    <!-- Navigation starts -->
                    <nav class="h-16 flex items-center items-stretch justify-end justify-between bg-white shadow relative z-0">
                        <div class="flex w-full">
                            <div class="text-gray-600 visible ml-4 sm:ml-8 mr-4 mt-4" onclick="sidebarHandler(true)" id="menu">
                                <svg aria-label="Main Menu" aria-haspopup="true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu cursor-pointer" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <line x1="4" y1="6" x2="20" y2="6" />
                                    <line x1="4" y1="12" x2="20" y2="12" />
                                    <line x1="4" y1="18" x2="20" y2="18" />
                                </svg>
                            </div>
                            <div class="w-1/2 h-full flex items-center px-8">
                                <!-- Page Header -->
                                {{ $header }}
                            </div>
                            <div class="w-1/2 flex px-4 sm:px-8">
                                <div class="w-full flex items-center justify-end">
                                    <div class="flex items-center relative cursor-pointer" onclick="dropdownHandler(this)">
                                        <div class="rounded-full">
                                            <ul class="p-2 w-full border-r bg-white absolute rounded left-0 shadow mt-12 sm:mt-16 hidden">
                                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center">
                                                    <form method="GET" action="{{ route('profile') }}">
                                                        @csrf
                                                        <x-dropdown-link :href="route('profile')"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                                                <div class="flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" />
                                                                        <circle cx="12" cy="7" r="4" />
                                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                                    </svg>
                                                                    <span class="text-sm ml-2">My Profile</span>
                                                                </div>
                                                        </x-dropdown-link>
                                                    </form>
                                                </li>
                                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mt-2">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <x-dropdown-link :href="route('logout')"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                                            <div class="flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                                                    <path d="M7 12h14l-3 -3m0 6l3 -3" />
                                                                </svg>
                                                                <span class="text-sm ml-2">Sign out</span>
                                                            </div>
                                                        </x-dropdown-link>
                                                    </form>
                                                </li>
                                            </ul>
                                            <div class="relative">
                                                <img class="h-10 w-16" src="http://localhost/Project/TrackMap/resources/views/components/img/white.png">
                                            </div>
                                        </div>
                                        <p class="text-gray-800 text-sm mx-3">{{ Auth::user()->name }}</p>
                                        <div class="cursor-pointer text-gray-600">
                                            <svg aria-haspopup="true" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <polyline points="6 9 12 15 18 9" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
