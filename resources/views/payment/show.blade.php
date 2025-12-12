@extends('layouts.app')

@section('title', 'Pembayaran - Mapala Senja')

@section('content')

<!-- Payment Content -->
<section class="py-28 bg-gradient-to-br from-gray-50 to-amber-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Payment Header --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 border-2 border-amber-100">
            <div class="bg-gradient-to-r from-[#EAB308] to-[#EAB308] px-8 py-6">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Detail Pembayaran
                </h1>
                <p class="text-amber-50 mt-2">Order ID: <span class="font-mono font-bold">{{ $pembayaran->order_id }}</span></p>
            </div>

            {{-- Status Badge --}}
            <div class="px-8 py-6 border-b-2 border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-2 font-medium">Status Pembayaran</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold {{ $pembayaran->getStatusBadgeClass() }} border-2" id="statusBadge">
                            {{ $pembayaran->getStatusLabel() }}
                        </span>
                    </div>
                    @if($pembayaran->isPending())
                        <button onclick="checkPaymentStatus()" 
                                class="px-6 py-3 bg-[#EAB308] text-white rounded-lg hover:bg-[#EAB308]-600 transition font-semibold shadow-md">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Cek Status
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Payment Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Transaction Info --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Informasi Transaksi
                    </h2>

                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Tanggal Pinjam</span>
                            <span class="font-bold text-gray-800">{{ $pembayaran->transaksi->tanggal_pinjam->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Tanggal Kembali</span>
                            <span class="font-bold text-gray-800">{{ $pembayaran->transaksi->tanggal_kembali->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Durasi Sewa</span>
                            <span class="font-bold text-amber-600">
                                {{ $pembayaran->transaksi->tanggal_pinjam->diffInDays($pembayaran->transaksi->tanggal_kembali) }} Hari
                            </span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-gray-600 font-medium">Status Transaksi</span>
                            <span class="font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $pembayaran->transaksi->status) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Equipment List --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Daftar Alat Disewa
                    </h2>

                    <div class="space-y-3">
                        @foreach($pembayaran->transaksi->detailTransaksis as $detail)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100">
                            <div class="flex items-center">
                                <div class="bg-[#EAB308] text-white p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $detail->alat->nama_alat }}</p>
                                    <p class="text-sm text-gray-600">{{ $detail->alat->kode_alat }}</p>
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

                {{-- Payment Method (if paid) --}}
                @if($pembayaran->payment_type)
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Metode Pembayaran
                    </h2>
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-4 border border-amber-200">
                        <p class="font-bold text-gray-800">{{ $pembayaran->getPaymentMethodLabel() }}</p>
                        @if($pembayaran->va_number)
                            <p class="text-sm text-gray-600 mt-1">VA Number: <span class="font-mono font-bold">{{ $pembayaran->va_number }}</span></p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Payment Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24 border-2 border-amber-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pembayaran</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-700">
                            <span class="font-medium">Jumlah Alat</span>
                            <span class="font-bold text-amber-600">{{ $pembayaran->transaksi->detailTransaksis->count() }} item</span>
                        </div>
                        <div class="border-t-2 border-gray-100 pt-4">
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border-2 border-amber-200">
                                <p class="text-sm text-gray-600 mb-2 text-center font-medium">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-amber-600 text-center">
                                    {{ $pembayaran->formatted_amount }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($pembayaran->isPending())
                        {{-- Payment Button --}}
                        <a href="{{ $pembayaran->payment_url }}" 
                           target="_blank"
                           class="block w-full bg-gradient-to-r from-[#EAB308] to-orange-500 text-white py-4 rounded-xl hover:from-amber-600 hover:to-orange-600 transition font-bold text-center shadow-lg mb-3">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        </a>
                        
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4 text-center">
                            <p class="text-sm text-yellow-800 font-semibold">
                                ⏳ Menunggu Pembayaran
                            </p>
                            <p class="text-xs text-yellow-600 mt-1">
                                Segera selesaikan pembayaran Anda
                            </p>
                        </div>
                    @elseif($pembayaran->isSuccess())
                        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 text-center mb-3">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-lg font-bold text-green-800">Pembayaran Berhasil!</p>
                            <p class="text-sm text-green-600 mt-1">Transaksi Anda telah dikonfirmasi</p>
                        </div>

                        @if($pembayaran->settlement_time)
                        <div class="text-center text-xs text-gray-500 mb-4">
                            Dibayar pada: {{ $pembayaran->settlement_time->format('d M Y H:i') }}
                        </div>
                        @endif
                    @elseif($pembayaran->isFailed())
                        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 text-center">
                            <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-lg font-bold text-red-800">Pembayaran Gagal</p>
                            <p class="text-sm text-red-600 mt-1">{{ $pembayaran->getStatusLabel() }}</p>
                        </div>
                    @endif

                    <a href="{{ route('home') }}" class="block text-center mt-6 text-amber-600 hover:text-amber-700 font-semibold">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Auto Check Status Script --}}
@if($pembayaran->isPending())
<script>
let checkInterval;

// Function to check payment status
function checkPaymentStatus() {
    fetch('{{ route("payment.check", $pembayaran->id) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update status badge
                const statusBadge = document.getElementById('statusBadge');
                if (statusBadge) {
                    statusBadge.textContent = data.message;
                }

                // If payment is successful, reload page
                if (data.is_success) {
                    clearInterval(checkInterval);
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        });
}

// Auto check every 10 seconds
document.addEventListener('DOMContentLoaded', function() {
    checkInterval = setInterval(checkPaymentStatus, 10000);
});

// Clear interval when leaving page
window.addEventListener('beforeunload', function() {
    if (checkInterval) {
        clearInterval(checkInterval);
    }
});
</script>
@endif

@endsection