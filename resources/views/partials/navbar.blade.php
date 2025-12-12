<!-- Navbar -->
<nav class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 shadow-2xl fixed w-full top-0 z-50 border-b-4 border-yellow-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.png') }}" alt="Mapala Senja Logo" class="w-16 h-16 logo-shadow">
                <div>
                    <h1 class="text-xl font-bold text-yellow-400">Mapala Senja</h1>
                    <p class="text-xs text-yellow-200">PSDKU Polinema di Kota Kediri</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-gray-100 hover:text-yellow-400 transition font-medium">Beranda</a>
                <a href="#about" class="text-gray-100 hover:text-yellow-400 transition font-medium">Tentang</a>
                <a href="#activities" class="text-gray-100 hover:text-yellow-400 transition font-medium">Kegiatan</a>
                <a href="#equipment" class="text-gray-100 hover:text-yellow-400 transition font-medium">Sewa Alat</a>
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
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center ring-2 ring-yellow-300 group-hover:ring-yellow-400 transition">
                                    <span class="text-gray-900 font-bold text-sm uppercase">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-yellow-400 transition" 
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
                                 class="absolute right-0 mt-3 w-56 bg-gray-800 rounded-xl shadow-xl border border-yellow-500 py-2 z-50"
                                 style="display: none;">
                                
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-700">
                                    <p class="text-sm font-semibold text-yellow-400">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-300 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                   
                                    <a href="{{ route('cart.index') }}" 
                                       class="flex items-center px-4 py-2.5 text-sm text-gray-200 hover:bg-gray-700 hover:text-yellow-400 transition">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Keranjang
                                        @if(session('cart') && count(session('cart')) > 0)
                                            <span class="ml-auto bg-yellow-500 text-gray-900 text-xs font-bold rounded-full px-2 py-0.5">
                                                {{ count(session('cart')) }}
                                            </span>
                                        @endif
                                    </a>
                                    <!-- Riwayat Transaksi -->
                                    <a href="{{ route('transactions.index') }}" 
                                    class="flex items-center px-4 py-2.5 text-sm text-gray-200 hover:bg-gray-700 hover:text-yellow-400 transition">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Riwayat Transaksi
                                    </a>

                                    <div class="border-t border-gray-700 my-1"></div>


                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-400 hover:bg-gray-700 transition">
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
                           class="px-5 py-2.5 text-gray-100 hover:text-yellow-400 transition font-medium border border-yellow-500 rounded-lg hover:bg-yellow-500 hover:text-gray-900">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold shadow-lg">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</nav>