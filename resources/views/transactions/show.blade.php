@extends('layouts.app')

@section('title', 'Detail Transaksi - Mapala Senja')

@section('content')

<!-- Transaction Detail Content -->
<section class="py-28 bg-gradient-to-br from-gray-50 to-amber-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-semibold mb-6 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Riwayat
        </a>

        {{-- Transaction Header --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 border-2 border-amber-100">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Detail Transaksi #{{ $transaction->id }}
                </h1>
                <p class="text-amber-50 mt-2">Dibuat pada {{ $transaction->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            {{-- Status Badge --}}
            <div class="px-8 py-6 border-b-2 border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-2 font-medium">Status Transaksi</p>
                        @php
                            $statusConfig = [
                                'menunggu_pembayaran' => ['class' => 'bg-yellow-100 text-yellow-800 border-yellow-300', 'label' => 'Menunggu Pembayaran'],
                                'disetujui' => ['class' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => 'Disetujui - Siap Diambil'],
                                'dipinjam' => ['class' => 'bg-purple-100 text-purple-800 border-purple-300', 'label' => 'Sedang Dipinjam'],
                                'selesai' => ['class' => 'bg-green-100 text-green-800 border-green-300', 'label' => 'Selesai'],
                                'dibatalkan' => ['class' => 'bg-red-100 text-red-800 border-red-300', 'label' => 'Dibatalkan'],
                            ];
                            $status = $statusConfig[$transaction->status] ?? ['class' => 'bg-gray-100 text-gray-800 border-gray-300', 'label' => $transaction->status];
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold border-2 {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                    @if($transaction->status === 'menunggu_pembayaran' && $transaction->pembayaran)
                        <a href="{{ route('payment.show', $transaction->pembayaran->id) }}" 
                           class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold shadow-md">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Lanjutkan Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Rental Period Info --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Periode Penyewaan
                    </h2>

                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Tanggal Ajuan</span>
                            <span class="font-bold text-gray-800">{{ $transaction->tanggal_ajuan->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Tanggal Pinjam</span>
                            <span class="font-bold text-gray-800">{{ $transaction->tanggal_pinjam->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Tanggal Kembali</span>
                            <span class="font-bold text-gray-800">{{ $transaction->tanggal_kembali->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-gray-600 font-medium">Durasi Sewa</span>
                            <span class="font-bold text-amber-600">
                                {{ $transaction->tanggal_pinjam->diffInDays($transaction->tanggal_kembali) }} Hari
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Equipment List --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Daftar Alat yang Disewa
                    </h2>

                    <div class="space-y-3">
                        @foreach($transaction->detailTransaksis as $detail)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition">
                            <div class="flex items-center flex-1">
                                <div class="bg-[#EAB308] text-white p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $detail->alat->nama_alat }}</p>
                                    <p class="text-sm text-gray-600">{{ $detail->alat->kode_alat }}</p>
                                    @if($detail->kondisi_kembali)
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded {{ $detail->kondisi_kembali === 'baik' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            Dikembalikan: {{ ucfirst($detail->kondisi_kembali) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-amber-600">Rp {{ number_format($detail->alat->harga_sewa, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">per hari</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Payment Information (if exists) --}}
                @if($transaction->pembayaran)
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Informasi Pembayaran
                    </h2>

                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Order ID</span>
                            <span class="font-mono font-bold text-gray-800 text-sm">{{ $transaction->pembayaran->order_id }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Status Pembayaran</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $transaction->pembayaran->getStatusBadgeClass() }}">
                                {{ $transaction->pembayaran->getStatusLabel() }}
                            </span>
                        </div>
                        @if($transaction->pembayaran->payment_type)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Metode Pembayaran</span>
                            <span class="font-bold text-gray-800">{{ $transaction->pembayaran->getPaymentMethodLabel() }}</span>
                        </div>
                        @endif
                        @if($transaction->pembayaran->va_number)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Virtual Account</span>
                            <span class="font-mono font-bold text-gray-800">{{ $transaction->pembayaran->va_number }}</span>
                        </div>
                        @endif
                        @if($transaction->pembayaran->settlement_time)
                        <div class="flex justify-between py-3">
                            <span class="text-gray-600 font-medium">Waktu Pembayaran</span>
                            <span class="font-bold text-gray-800">{{ $transaction->pembayaran->settlement_time->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>

                    @if($transaction->pembayaran->isPending())
                        <a href="{{ route('payment.show', $transaction->pembayaran->id) }}" 
                           class="block mt-4 w-full text-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition font-bold shadow-md">
                            Lihat Detail Pembayaran
                        </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24 border-2 border-amber-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Biaya</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-700">
                            <span class="font-medium">Jumlah Alat</span>
                            <span class="font-bold text-amber-600">{{ $transaction->detailTransaksis->count() }} item</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span class="font-medium">Durasi</span>
                            <span class="font-bold text-amber-600">{{ $transaction->tanggal_pinjam->diffInDays($transaction->tanggal_kembali) }} hari</span>
                        </div>
                        
                        <div class="border-t-2 border-gray-100 pt-4">
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border-2 border-amber-200">
                                <p class="text-sm text-gray-600 mb-2 text-center font-medium">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-amber-600 text-center">
                                    Rp {{ number_format($transaction->total_biaya, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    @if($transaction->status === 'menunggu')
                        @if($transaction->pembayaran)
                            <a href="{{ $transaction->pembayaran->payment_url }}" 
                               class="block w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition font-bold text-center shadow-lg mb-3">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Bayar Sekarang
                            </a>
                        @endif

                        <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin membatalkan transaksi ini?')"
                                    class="w-full bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 transition font-bold text-center">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batalkan Transaksi
                            </button>
                        </form>
                    @elseif($transaction->status === 'disetujui')
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 text-center mb-4">
                            <svg class="w-12 h-12 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-bold text-blue-800">Transaksi Disetujui!</p>
                            <p class="text-xs text-blue-600 mt-1">Alat siap diambil</p>
                        </div>
                    @elseif($transaction->status === 'dipinjam')
                        <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-4 text-center mb-4">
                            <svg class="w-12 h-12 text-purple-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-bold text-purple-800">Sedang Dipinjam</p>
                            <p class="text-xs text-purple-600 mt-1">Jangan lupa kembalikan tepat waktu</p>
                        </div>
                    @elseif($transaction->status === 'selesai')
                        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 text-center mb-4">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-bold text-green-800">Transaksi Selesai</p>
                            <p class="text-xs text-green-600 mt-1">Terima kasih telah menyewa</p>
                        </div>
                    @elseif($transaction->status === 'dibatalkan')
                        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 text-center mb-4">
                            <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-bold text-red-800">Transaksi Dibatalkan</p>
                        </div>
                    @endif

                    <a href="{{ route('transactions.index') }}" class="block text-center mt-4 text-amber-600 hover:text-amber-700 font-semibold">
                        ← Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection