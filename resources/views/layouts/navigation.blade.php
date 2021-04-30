<script>
    
    let sideBar = document.getElementById("mobile-nav");
    let menu = document.getElementById("menu");
    let cross = document.getElementById("cross");
    const sidebarHandler = (check) => {
        if (check) {
            sideBar.style.transform = "translateX(0px)";
            menu.classList.add("hidden");
            cross.classList.remove("hidden");
        } else {
            sideBar.style.transform = "translateX(-100%)";
            menu.classList.remove("hidden");
            cross.classList.add("hidden");
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
        <!-- Sidebar starts -->
        <div class="w-64 absolute lg:relative bg-white shadow h-screen flex-col justify-between hidden lg:flex pb-12">
            <div class="px-8">
                <div class="h-16 w-full flex items-center">
                    <!-- logo -->
                </div>
                <ul class="mt-12 w-full">
                    <li class="flex w-full justify-between text-indigo-700 cursor-pointer items-center mb-6">
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Dasboard') }}
                        </x-dropdown-link>
                    </li>
                    <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                        <x-dropdown-link :href="route('company_form')">
                            {{ __('Destinations') }}
                        </x-dropdown-link>
                    </li>
                    <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                        <x-dropdown-link :href="route('employee_list')">
                            {{ __('Employee') }}
                        </x-dropdown-link>
                    </li>
                    <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Task') }}
                        </x-dropdown-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="absolute w-full h-full transform -translate-x-full z-40 lg:hidden" id="mobile-nav">
            <div class="bg-gray-800 opacity-50 w-full h-full absolute" onclick="sidebarHandler(false)"></div>
            <div class="w-64 md:w-96 absolute z-40 bg-white shadow h-full flex-col justify-between lg:hidden pb-4 transition duration-150 ease-in-out">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center justify-between px-8">
                            <div class="h-16 w-full flex items-center">
                                {{-- logo --}}
                            </div>
                            <div id="closeSideBar" class="flex items-center justify-center h-10 w-10" onclick="sidebarHandler(false)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </div>
                        </div>
                        <div class="px-8">
                            <ul class="mt-12">
                                <li class="flex w-full justify-between text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <span class="xl:text-base md:text-2xl text-base ml-2">Dashboard</span>
                                    </div>
                                    <div class="py-1 px-3 bg-indigo-700 rounded text-white flex items-center justify-center text-xs">5</div>
                                </li>
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <span class="xl:text-base md:text-2xl text-base ml-2">Destination</span>
                                    </div>
                                    <div class="py-1 px-3 bg-indigo-700 rounded text-white flex items-center justify-center text-xs">8</div>
                                </li>
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <span class="xl:text-base md:text-2xl text-base ml-2">Employee</span>
                                    </div>
                                </li>
                                <li class="flex w-full justify-between text-gray-600 hover:text-indigo-700 cursor-pointer items-center mb-6">
                                    <div class="flex items-center">
                                        <span class="xl:text-base md:text-2xl text-base ml-2">Task</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex justify-center mb-4 w-full px-6">
                            <div class="relative w-full">
                                <div class="text-gray-500 absolute ml-4 inset-0 m-auto w-4 h-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="#A0AEC0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"></path>
                                        <circle cx="10" cy="10" r="7"></circle>
                                        <line x1="21" y1="21" x2="15" y2="15"></line>
                                    </svg>
                                </div>
                                <input class="bg-gray-100 focus:outline-none rounded w-full text-sm text-gray-500 bg-gray-100 pl-10 py-2" type="text" placeholder="Search" />
                            </div>
                        </div>
                        <div class="border-t border-gray-300">
                            <div class="w-full flex items-center justify-between px-6 pt-1">
                                <div class="flex items-center">
                                    <img alt="profile-pic" src="https://tuk-cdn.s3.amazonaws.com/assets/components/boxed_layout/bl_1.png" class="w-8 h-8 rounded-md" />
                                    <p class="md:text-xl text-gray-800 text-base leading-4 ml-2">Jane Doe</p>
                                </div>
                                <ul class="flex">
                                    <li class="cursor-pointer text-white pt-5 pb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#718096" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10"></path>
                                            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2"></path>
                                        </svg>
                                    </li>
                                    <li class="cursor-pointer text-white pt-5 pb-3 pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#718096" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"></path>
                                            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                                        </svg>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Mobile responsive sidebar-->
        <!-- Sidebar ends -->
        <div class="w-full">
            <!-- Navigation starts -->
            <nav class="h-16 flex items-center lg:items-stretch justify-end lg:justify-between bg-white shadow relative z-0">
                <div class="hidden lg:flex w-full pr-6">
                    <div class="w-full hidden lg:flex">
                        <div class="w-1/2 flex items-center pl-8 right-end">
                            <!-- Page Heading -->
                            {{ $header }}
                        </div>
                        <div class="w-1/2 flex items-center pl-8 justify-end">
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div>{{ Auth::user()->name }}</div>
                
                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>
                
                                    <x-slot name="content">
                                        <form method="POST" action="{{ route('profile') }}">
                                            <x-dropdown-link :href="route('register')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                                        </form>
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
