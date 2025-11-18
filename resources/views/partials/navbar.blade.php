<!-- Navbar -->
<nav class="bg-white shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xl">MS</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Mapala Senja</h1>
                    <p class="text-xs text-gray-600">Polinema Kediri</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-gray-700 hover:text-amber-600 transition font-medium">Beranda</a>
                <a href="#about" class="text-gray-700 hover:text-amber-600 transition font-medium">Tentang</a>
                <a href="#activities" class="text-gray-700 hover:text-amber-600 transition font-medium">Kegiatan</a>
                <a href="#equipment" class="text-gray-700 hover:text-amber-600 transition font-medium">Sewa Alat</a>
            </div>

            <!-- Auth Links -->
            @if (Route::has('login'))
                <nav class="flex items-center space-x-3">
                    @auth
                         <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <!-- Avatar Button -->
                            <button @click="open = !open" @click.away="open = false" 
                                    class="flex items-center space-x-3 focus:outline-none group">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-600 rounded-full flex items-center justify-center ring-2 ring-amber-200 group-hover:ring-amber-400 transition">
                                    <span class="text-white font-bold text-sm uppercase">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-600 group-hover:text-amber-600 transition" 
                                     :class="{'rotate-180': open}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                                 style="display: none;">
                                
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                   
                                    <a href="{{ route('cart.index') }}" 
                                       class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Keranjang
                                        @if(session('cart') && count(session('cart')) > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                                {{ count(session('cart')) }}
                                            </span>
                                        @endif
                                    </a>

                                    <div class="border-t border-gray-100 my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-5 py-2.5 text-gray-700 hover:text-amber-600 transition font-medium">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-medium shadow-md">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</nav>