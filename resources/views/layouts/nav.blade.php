    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-700 text-white shadow-md" x-data="{ profileOpen: false }">

        <div class="w-full mx-auto px-4 sm:px-6 lg:px-12">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center text-lg font-bold tracking-wide">
                    <div class="flex items-center justify-center w-12 h-12 bg-white rounded p-1">
                        <img src="{{ asset('logo/logo.png') }}" class="" alt="Logo">
                    </div>
                    <div class="flex flex-col">
                        <span class="ml-2">University of Rajshahi</span>
                        <span class="ml-2 text-sm font-sm">Residential Application</span>
                    </div>
                </a>

                @if (auth()->check() && auth()->user()->isAdmin())
                    <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" class="hidden">
                        @csrf
                    </form>
                @elseif(auth()->check())
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
                        @csrf
                    </form>
                @endif

                @if (auth()->check())
                    <!-- Desktop Menu -->
                    <div class="flex items-center space-x-6">

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen"
                                class="flex items-center gap-2 hover:opacity-80 transition">

                                <div
                                    class="w-8 h-8 rounded-full bg-white text-[#009bd6] flex items-center justify-center">
                                    <i class="fa fa-user text-sm text-gray-800"></i>
                                </div>

                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4z" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition
                                class="absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded shadow-lg overflow-hidden z-20 border border-gray-500">

                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fa fa-sign-out mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="h-16"></div>
