@extends('layouts.app')

@section('title', 'Beranda - Mapala Senja Polinema Kediri')

@section('content')

    <!-- Hero Section -->
    <section id="home"
        class="pt-32 pb-20 bg-gradient-to-br from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 0l30 30-30 30L0 30z" fill="%23EAB308" fill-opacity="0.4" /></svg>'); background-size: 60px
                60px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-5xl font-bold mb-6 leading-tight text-shadow">
                        Mapala Senja<br />
                        <span class="text-yellow-400">PSDKU Polinema Kediri</span>
                    </h1>
                    <p class="text-xl mb-8 text-gray-200 leading-relaxed">
                        Mahasiswa Pecinta Alam.
                        Jelajahi alam, temukan petualangan, dan bergabunglah bersama kami!
                    </p>
                    <div class="flex space-x-4">
                        <a href="#equipment"
                            class="px-8 py-4 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold shadow-xl">
                            Sewa Alat
                        </a>
                        <a href="#about"
                            class="px-8 py-4 bg-gray-800 text-yellow-400 rounded-lg hover:bg-gray-700 transition font-semibold border-2 border-yellow-500">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}" alt="Mapala Senja Logo"
                            class="w-full max-w-md mx-auto logo-shadow animate-pulse">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-4xl font-bold text-center text-gray-800 mb-4 section-title">
                Tentang Mapala Senja
            </h2>

            <p class="text-center text-gray-600 mb-16 max-w-3xl mx-auto">
                Mapala Senja hadir bukan sekadar sebagai komunitas pendaki, tetapi sebagai
                wadah pembentukan karakter, kepedulian sosial, dan kecintaan terhadap alam
                melalui eksplorasi, pendidikan, dan aksi konservasi lingkungan.
            </p>

            <div class="grid md:grid-cols-3 gap-8">

                <!-- Sejarah -->
                <div
                    class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition border-2 border-yellow-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Sejarah & Filosofi
                    </h3>

                    <p class="text-gray-700 leading-relaxed">
                        Mahasiswa Pecinta Alam (Mapala) lahir pada era 1960–1970an sebagai
                        bentuk pencarian ruang kebebasan mahasiswa ketika aktivitas politik di
                        kampus dibatasi. Alam menjadi ruang belajar alternatif untuk mengenal
                        masyarakat dan tanah air secara langsung.
                    </p>

                    <p class="text-gray-700 leading-relaxed mt-3">
                        Mapala UI yang berdiri pada 12 Desember 1964 menjadi pelopor gerakan ini.
                        Tokoh seperti Soe Hok Gie memandang bahwa patriotisme sejati lahir dari
                        pengembaraan dan interaksi langsung dengan alam serta masyarakat,
                        bukan sekadar slogan.
                    </p>
                </div>

                <!-- Visi & Misi -->
                <div
                    class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition border-2 border-yellow-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                                c4.478 0 8.268 2.943 9.542 7
                                -1.274 4.057-5.064 7-9.542 7
                                -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Visi & Misi
                    </h3>

                    <p class="text-gray-700 mb-3 leading-relaxed">
                        <strong>Visi:</strong> Mewujudkan anggota yang memiliki kesadaran dan
                        kepedulian tinggi terhadap lingkungan, alam, serta masyarakat sosial.
                    </p>

                    <ul class="text-gray-700 leading-relaxed space-y-2">
                        <li>• Menjadikan AD/ART sebagai pedoman utama dalam berorganisasi.</li>
                        <li>• Membina anggota agar berwawasan luas dan berkembang di bidang
                            pecinta alam serta kegiatan sosial.</li>
                        <li>• Menjadi wadah pengembangan bakat dan kreativitas anggota.</li>
                    </ul>
                </div>

                <!-- Divisi Operasional -->
                <div
                    class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition border-2 border-yellow-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Divisi Operasional
                    </h3>

                    <ul class="text-gray-700 leading-relaxed space-y-2">
                        <li><strong>Lingkungan Hidup</strong> — Konservasi dan pelestarian ekosistem.</li>
                        <li><strong>Gunung & Hutan</strong> — Pendakian teknis dan manajemen perjalanan alam bebas.</li>
                        <li><strong>Olahraga Arus Deras</strong> — Navigasi sungai seperti rafting & kayaking.</li>
                        <li><strong>Panjat Tebing</strong> — Teknik pemanjatan pada medan vertikal.</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="activities" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-4xl font-bold text-center text-gray-800 mb-4 section-title">
                Kegiatan & Divisi Kami
            </h2>

            <p class="text-center text-gray-600 mb-16 max-w-3xl mx-auto">
                Kegiatan Mapala Senja berfokus pada eksplorasi alam, pengembangan kemampuan anggota,
                serta kontribusi nyata terhadap pelestarian lingkungan melalui berbagai divisi operasional.
            </p>

            <div class="grid md:grid-cols-4 gap-6">

                <!-- Gunung & Hutan -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center border-2 border-transparent hover:border-yellow-500">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20l9-16 9 16H3z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Gunung & Hutan
                    </h3>

                    <p class="text-gray-600 text-sm">
                        Kegiatan pendakian gunung, navigasi hutan, serta manajemen perjalanan alam bebas.
                    </p>
                </div>

                <!-- Lingkungan Hidup -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center border-2 border-transparent hover:border-yellow-500">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2C8 7 5 10 5 13a7 7 0 0014 0c0-3-3-6-7-11z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Lingkungan Hidup
                    </h3>

                    <p class="text-gray-600 text-sm">
                        Program konservasi, aksi lingkungan, serta edukasi pelestarian ekosistem.
                    </p>
                </div>

                <!-- Arus Deras -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center border-2 border-transparent hover:border-yellow-500">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2 12c3-4 6 4 9 0s6 4 9 0" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Olahraga Arus Deras
                    </h3>

                    <p class="text-gray-600 text-sm">
                        Navigasi sungai seperti rafting dan kayaking yang menuntut ketangkasan tim.
                    </p>
                </div>

                <!-- Panjat Tebing -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition text-center border-2 border-transparent hover:border-yellow-500">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2l4 8-4 4-4-4 4-8z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Panjat Tebing
                    </h3>

                    <p class="text-gray-600 text-sm">
                        Olahraga ekstrem pemanjatan pada medan vertikal baik tebing alam maupun buatan.
                    </p>
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

            @if (isset($alats) && $alats->count() > 0)
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($alats as $alat)
                        <div
                            class="bg-gradient-to-br from-white to-yellow-50 border-2 border-yellow-300 rounded-xl p-6 hover:shadow-xl transition hover:border-yellow-500 flex flex-col">
                            <!-- Image Section -->
                            <div class="mb-4 overflow-hidden rounded-lg border border-yellow-200 bg-yellow-100">
                                @if ($alat->image)
                                    <img src="{{ asset('storage/' . $alat->image) }}"
                                        alt="{{ $alat->nama_alat }}"
                                        class="h-44 w-full object-cover">
                                @else
                                    <div class="h-44 w-full flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-700">
                                        <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 16.5V7.8A1.8 1.8 0 014.8 6h14.4A1.8 1.8 0 0121 7.8v8.4a1.8 1.8 0 01-1.8 1.8H4.8A1.8 1.8 0 013 16.2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8.25 10.5h.008v.008H8.25V10.5zm-2.25 5.25 3.75-3.75a1.5 1.5 0 012.121 0l1.379 1.379a1.5 1.5 0 002.121 0L18 10.75" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Header Section -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-yellow-600 mb-1">{{ $alat->kode_alat }}</p>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $alat->nama_alat }}</h3>
                                </div>
                                @if ($alat->status === 'tersedia')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-300">Tersedia</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-300">Tidak Tersedia</span>
                                @endif
                            </div>

                            <!-- Stok Info -->
                            <div class="mb-3">
                                <span class="inline-flex items-center text-xs font-medium {{ $alat->total_tersedia > 0 ? 'text-green-700' : 'text-red-600' }}">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    Stok tersedia: {{ $alat->total_tersedia }} unit
                                </span>
                            </div>

                            <!-- Price Section -->
                            <div class="border-t border-yellow-300 pt-1 mt-auto">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">Harga Sewa</p>
                                        <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">per hari</p>
                                    </div>
                                </div>

                                <!-- Button Section -->
                                @if ($alat->status === 'tersedia')
                                    @auth
                                        @if ($punyaTransaksiAktif)
                                            <div class="w-full">
                                                <div class="mb-3 rounded-lg border border-orange-200 bg-orange-50 px-3 py-2 text-xs text-orange-700">
                                                    Anda masih memiliki transaksi alat yang sedang berjalan.
                                                </div>
                                                <button disabled
                                                    class="w-full px-4 py-2.5 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed font-medium">
                                                    Belum Bisa Sewa Lagi
                                                </button>
                                            </div>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="alat_id" value="{{ $alat->available_id }}">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <label class="text-xs text-gray-600 font-medium whitespace-nowrap">Jumlah:</label>
                                                    <input type="number"
                                                        name="jumlah"
                                                        value="1"
                                                        min="1"
                                                        max="{{ $alat->total_tersedia }}"
                                                        class="w-full px-3 py-1.5 border-2 border-yellow-300 rounded-lg text-sm font-semibold text-center focus:border-yellow-500 focus:outline-none">
                                                    <span class="text-xs text-gray-500 whitespace-nowrap">/ {{ $alat->total_tersedia }}</span>
                                                </div>
                                                <button type="submit"
                                                    class="w-full px-4 py-2.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold flex items-center justify-center space-x-2 shadow-md">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    <span>Tambah ke Keranjang</span>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full px-4 py-2.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold text-center shadow-md">
                                            Login untuk Sewa
                                        </a>
                                    @endauth
                                @else
                                    <button disabled
                                        class="w-full px-4 py-2.5 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed font-medium">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada alat yang tersedia saat ini</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 0l30 30-30 30L0 30z" fill="%23EAB308" fill-opacity="0.4" /></svg>'); background-size: 60px
                60px;">
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-6 text-shadow">Bergabunglah Bersama Kami!</h2>
            <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                Mari bersama-sama menjelajahi keindahan alam Indonesia dan berkontribusi dalam pelestariannya
            </p>
            @guest
                <a href="{{ route('register') }}"
                    class="inline-block px-10 py-4 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold text-lg shadow-xl">
                    Daftar Sekarang
                </a>
            @else
                <a href="#equipment"
                    class="inline-block px-10 py-4 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition font-bold text-lg shadow-xl">
                    Sewa Sekarang
                </a>
            @endguest
        </div>
    </section>

@endsection
