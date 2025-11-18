@extends('layouts.app')

@section('title', 'Beranda - Mapala Senja Polinema Kediri')

@section('content')

<!-- Hero Section -->
<section id="home" class="pt-32 pb-20 gradient-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <h1 class="text-5xl font-bold mb-6 leading-tight">
                    Mapala Senja<br/>
                    <span class="text-yellow-200">Polinema Kediri</span>
                </h1>
                <p class="text-xl mb-8 text-yellow-50 leading-relaxed">
                    Mahasiswa Pecinta Alam. 
                    Jelajahi alam, temukan petualangan, dan bergabunglah bersama kami!
                </p>
                <div class="flex space-x-4">
                    <a href="#equipment" class="px-8 py-4 bg-white text-amber-600 rounded-lg hover:bg-gray-100 transition font-semibold shadow-xl">
                        Sewa Alat
                    </a>
                    <a href="#about" class="px-8 py-4 bg-amber-700 text-white rounded-lg hover:bg-amber-800 transition font-semibold">
                        Selengkapnya
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-full h-96 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl">
                    <svg class="w-64 h-64 text-white/80" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-4 section-title">Tentang Kami</h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Mengenal lebih dekat Mapala Senja Polinema Kediri
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Sejarah -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Sejarah</h3>
                <p class="text-gray-600 leading-relaxed">
                    Mapala Senja didirikan oleh sekelompok mahasiswa pecinta alam Polinema Kediri yang memiliki semangat tinggi untuk menjelajahi dan melestarikan alam Indonesia. Sejak berdiri, kami telah melakukan berbagai ekspedisi dan kegiatan konservasi.
                </p>
            </div>

            <!-- Visi -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi organisasi mahasiswa pecinta alam yang unggul dalam eksplorasi, konservasi, dan pendidikan lingkungan, serta membentuk karakter mahasiswa yang tangguh, mandiri, dan peduli terhadap kelestarian alam Indonesia.
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi</h3>
                <ul class="text-gray-600 leading-relaxed space-y-2">
                    <li>• Melakukan ekspedisi dan penelitian alam</li>
                    <li>• Menyelenggarakan pendidikan kepecintaalaman</li>
                    <li>• Melakukan aksi konservasi lingkungan</li>
                    <li>• Membangun jaringan pecinta alam</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Activities Section -->
<section id="activities" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-4 section-title">Kegiatan Kami</h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Berbagai kegiatan petualangan dan konservasi yang kami lakukan
        </p>

        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pendakian Gunung</h3>
                <p class="text-gray-600 text-sm">Ekspedisi ke gunung-gunung di seluruh Indonesia</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Susur Gua</h3>
                <p class="text-gray-600 text-sm">Penelusuran gua dan ekosistem karst</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konservasi Alam</h3>
                <p class="text-gray-600 text-sm">Program pelestarian lingkungan dan satwa</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pelatihan</h3>
                <p class="text-gray-600 text-sm">Pendidikan dasar dan lanjutan kepecintaalaman</p>
            </div>
        </div>
    </div>
</section>

<!-- Equipment Section -->
<section id="equipment" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-4 section-title">Sewa Alat Logistik</h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Kami menyediakan berbagai peralatan pendakian dan camping untuk disewa dengan harga terjangkau
        </p>

        @if(isset($alats) && $alats->count() > 0)
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($alats as $alat)
                    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:shadow-xl transition hover:border-amber-200 flex flex-col">
                        <!-- Header Section -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-amber-600 mb-1">{{ $alat->kode_alat }}</p>
                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $alat->nama_alat }}</h3>
                            </div>
                            @if($alat->status == 'tersedia')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Tersedia</span>
                            @elseif($alat->status == 'dipinjam')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Dipinjam</span>
                            @elseif($alat->status == 'rusak')
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Rusak</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">Hilang</span>
                            @endif
                        </div>
                        
                        <!-- Price Section -->
                        <div class="border-t border-gray-100 pt-1 mt-auto">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="text-xs text-gray-500">Harga Sewa</p>
                                    <p class="text-2xl font-bold text-amber-600">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">per hari</p>
                                </div>
                            </div>

                            <!-- Button Section (Always at bottom) -->
                            @if($alat->status == 'tersedia')
                                @auth
                                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                                        <button type="submit" class="w-full px-4 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-medium flex items-center justify-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span>Tambah</span>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full px-4 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-medium text-center">
                                        Login untuk Sewa
                                    </a>
                                @endauth
                            @else
                                <button disabled class="w-full px-4 py-2.5 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed font-medium">
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada alat yang tersedia saat ini</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Bergabunglah Bersama Kami!</h2>
        <p class="text-xl text-yellow-50 mb-8 leading-relaxed">
            Mari bersama-sama menjelajahi keindahan alam Indonesia dan berkontribusi dalam pelestariannya
        </p>
        @guest
            <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-amber-600 rounded-lg hover:bg-gray-100 transition font-bold text-lg shadow-xl">
                Daftar Sekarang
            </a>
        @else
            <a href="#equipment" class="inline-block px-10 py-4 bg-white text-amber-600 rounded-lg hover:bg-gray-100 transition font-bold text-lg shadow-xl">
                Sewa Sekarang
            </a>
        @endguest
    </div>
</section>

@endsection