@extends('layouts.app')

@section('title', 'Status Pembayaran - Mapala Senja')

@section('content')

<section class="py-28 bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            @if($pembayaran->isSuccessful())
                <!-- Success State -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4">
                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-green-50">Terima kasih, pesanan Anda sedang diproses</p>
                </div>
            @elseif($pembayaran->isPending())
                <!-- Pending State -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4">
                        <svg class="w-12 h-12 text-amber-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Menunggu Pembayaran</h1>
                    <p class="text-amber-50">Silakan selesaikan pembayaran Anda</p>
                </div>
            @else
                <!-- Failed State -->
                <div class="bg-gradient-to-r from-red-500 to-rose-500 px-8 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4">
                        <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pembayaran Gagal</h1>
                    <p class="text-red-50">Silakan coba lagi atau hubungi customer service</p>
                </div>
            @endif

            <!-- Payment Details -->
            <div class="p-8">
                <div class="space-y-6">
                    <!-- Order Info -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pesanan</h2>
                        <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID</span>
                                <span class="font-mono font-semibold text-gray-800">{{ $pembayaran->order_id }}</span>
                            </div>
                            @if($pembayaran->transaction_id)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction ID</span>
                                <span class="font-mono text-sm text-gray-800">{{ $pembayaran->transaction_id }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Pembayaran</span>
                                <span class="font-bold text-gray-800">
                                    Rp {{ number_format($pembayaran->gross_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    @if($pembayaran->isSuccessful()) bg-green-100 text-green-700
                                    @elseif($pembayaran->isPending()) bg-amber-100 text-amber-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ strtoupper($pembayaran->transaction_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method (if available) -->
                    @if($pembayaran->payment_type)
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800 capitalize">
                                        {{ str_replace('_', ' ', $pembayaran->payment_type) }}
                                    </p>
                                    @if($pembayaran->bank)
                                    <p class="text-sm text-gray-600">{{ strtoupper($pembayaran->bank) }}</p>
                                    @endif
                                    @if($pembayaran->va_number)
                                    <p class="text-sm font-mono text-gray-700 mt-1">{{ $pembayaran->va_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Transaction Details -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Detail Transaksi</h2>
                        <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pinjam</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $pembayaran->transaksi->tanggal_pinjam->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Kembali</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $pembayaran->transaksi->tanggal_kembali->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $pembayaran->transaksi->detailTransaksis->count() }} alat
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        @if($pembayaran->isPending())
                            <button onclick="checkPaymentStatus()" 
                                    class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition font-semibold">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Cek Status Pembayaran
                            </button>
                            
                            @if($pembayaran->payment_url)
                            <a href="{{ $pembayaran->payment_url }}" 
                               class="block w-full text-center bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                                Lanjutkan Pembayaran
                            </a>
                            @endif
                        @endif

                        @if($pembayaran->isSuccessful())
                            <a href="{{ route('transaksi.show', $pembayaran->transaksi_id) }}" 
                               class="block w-full text-center bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition font-semibold">
                                Lihat Detail Transaksi
                            </a>
                        @endif

                        <a href="{{ url('/') }}" 
                           class="block w-full text-center border-2 border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition font-semibold">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function checkPaymentStatus() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memeriksa...';
    
    fetch('{{ route('payment.check-status', $pembayaran->id) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat memeriksa status pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memeriksa status pembayaran');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        });
}

// Auto refresh untuk pending payment setiap 30 detik
@if($pembayaran->isPending())
setInterval(function() {
    checkPaymentStatus();
}, 30000);
@endif
</script>
@endpush