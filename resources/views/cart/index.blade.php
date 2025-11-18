@extends('layouts.app')

@section('title', 'Keranjang Sewa - Mapala Senja')

@section('content')

<!-- Cart Content -->
<section class="py-28 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Sewa Alat</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <p class="font-semibold mb-2">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(count($cart) == 0)
            {{-- Empty Cart --}}
            <div class="text-center py-16">
                <svg class="w-32 h-32 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-6">Belum ada alat yang ditambahkan ke keranjang</p>
                <a href="/#equipment" class="inline-block px-8 py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition font-semibold">
                    Lihat Daftar Alat
                </a>
            </div>
        @else
            {{-- Cart Items & Calculation --}}
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Items List --}}
                <div class="lg:col-span-2">
                    {{-- Table View --}}
                    <div class="bg-white border-2 border-gray-100 rounded-xl overflow-hidden mb-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gradient-to-r from-amber-50 to-orange-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Kode</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Nama Alat</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Harga / Hari</th>
                                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-800">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($cart as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-semibold text-amber-600">{{ $item['kode_alat'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-gray-800">{{ $item['nama_alat'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-gray-800">Rp {{ number_format($item['harga_sewa'], 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition"
                                                        onclick="return confirm('Hapus alat dari keranjang?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Calculation Form --}}
                    <div class="bg-gradient-to-br from-amber-50 to-indigo-50 rounded-xl p-6 border-2 border-amber-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Hitung Total Penyewaan
                        </h3>

                        <form action="{{ route('cart.calculate') }}" method="POST">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pinjam</label>
                                    <input type="date" 
                                           name="tanggal_pinjam" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition"
                                           value="{{ old('tanggal_pinjam', $tanggal_pinjam ?? '') }}" 
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kembali</label>
                                    <input type="date" 
                                           name="tanggal_kembali" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition"
                                           value="{{ old('tanggal_kembali', $tanggal_kembali ?? '') }}" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           required>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-4 mb-4 border-2 border-amber-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-700">Total harga per hari:</span>
                                    <span class="text-lg font-bold text-gray-800">Rp {{ number_format($total_per_hari, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @isset($total_biaya)
                            <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-semibold text-green-800">Total Biaya</p>
                                        <p class="text-xs text-green-600">Durasi: {{ $durasi }} hari</p>
                                    </div>
                                    <span class="text-2xl font-bold text-green-700">
                                        Rp {{ number_format($total_biaya, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            @endisset

                            <button type="submit" class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-700 transition font-semibold shadow-md flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Hitung Total
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Summary Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 sticky top-24 border-2 border-amber-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Keranjang</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-700">
                                <span class="font-medium">Total Item</span>
                                <span class="font-bold text-amber-600">{{ count($cart) }} alat</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span class="font-medium">Harga per hari</span>
                                <span class="font-bold text-amber-600">Rp {{ number_format($total_per_hari, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @isset($total_biaya)
                        <div class="border-t-2 border-amber-300 pt-4 mb-6">
                            <div class="bg-white rounded-lg p-4 border-2 border-amber-300">
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                                    <p class="text-3xl font-bold text-amber-600">
                                        Rp {{ number_format($total_biaya, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">untuk {{ $durasi }} hari</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tanggal_pinjam" value="{{ $tanggal_pinjam }}">
                            <input type="hidden" name="tanggal_kembali" value="{{ $tanggal_kembali }}">
                            <input type="hidden" name="total_biaya" value="{{ $total_biaya }}">
                            
                            <button type="submit" 
                                    class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition font-semibold mb-3 shadow-md">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Proses Pemesanan
                            </button>
                        </form>
                        @endisset

                        <a href="/#equipment" class="block text-center mt-4 text-amber-600 hover:text-amber-700 font-medium">
                            ← Lanjut Pilih Alat
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection