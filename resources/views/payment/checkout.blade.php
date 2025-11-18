@extends('layouts.app')

@section('title', 'Pembayaran - Mapala Senja')

@section('content')

<section class="py-28 bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <h1 class="text-3xl font-bold text-white">Pembayaran</h1>
                <p class="text-amber-50 mt-2">Order ID: {{ $pembayaran->order_id }}</p>
            </div>

            <!-- Transaction Details -->
            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Transaksi</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Pinjam</span>
                            <span class="font-semibold text-gray-800">
                                {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Kembali</span>
                            <span class="font-semibold text-gray-800">
                                {{ $transaksi->tanggal_kembali->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durasi Sewa</span>
                            <span class="font-semibold text-gray-800">
                                {{ $transaksi->tanggal_pinjam->diffInDays($transaksi->tanggal_kembali) }} hari
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Item</span>
                            <span class="font-semibold text-gray-800">
                                {{ $transaksi->detailTransaksis->count() }} alat
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Alat yang Disewa</h2>
                    
                    <div class="space-y-3">
                        @foreach($transaksi->detailTransaksis as $detail)
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $detail->alat->nama_alat }}</p>
                                <p class="text-sm text-gray-600">{{ $detail->alat->kode_alat }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-amber-600">
                                    Rp {{ number_format($detail->alat->harga_sewa, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500">per hari</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total Payment -->
                <div class="border-t-2 border-gray-200 pt-6 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">Total Pembayaran</span>
                        <span class="text-3xl font-bold text-amber-600">
                            Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Payment Button -->
                <button id="pay-button" 
                        class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-4 rounded-xl hover:from-amber-600 hover:to-orange-600 transition font-bold text-lg shadow-lg">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Lanjutkan ke Pembayaran
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Anda akan diarahkan ke halaman pembayaran Midtrans
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script 
    src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        
        console.log('=== MIDTRANS DEBUG ===');
        console.log('Snap loaded:', typeof window.snap !== 'undefined');
        console.log('Snap Token:', '{{ $snapToken }}');
        console.log('====================');

        const payButton = document.getElementById('pay-button');
        
        if (!payButton) {
            console.error('Pay button not found!');
            return;
        }

        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const snapToken = '{{ $snapToken }}';
            
            if (!snapToken || snapToken === '') {
                alert('Error: Token pembayaran tidak valid.');
                return;
            }

            // Disable button
            payButton.disabled = true;
            payButton.innerHTML = `
                <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengarahkan...
            `;

            // OPSI 1: Redirect dengan Snap (New Tab / Redirect)
            if (typeof window.snap !== 'undefined') {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("payment.result", $pembayaran->id) }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("payment.result", $pembayaran->id) }}';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal: ' + (result.status_message || 'Terjadi kesalahan'));
                        location.reload();
                    },
                    onClose: function() {
                        payButton.disabled = false;
                        payButton.innerHTML = `
                            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Lanjutkan ke Pembayaran
                        `;
                    }
                });
            } else {
                // OPSI 2: Jika snap tidak load, redirect manual ke payment gateway
                console.log('Snap not loaded, using manual redirect');
                
                // Request redirect URL dari backend
                fetch(`/payment/get-redirect-url/{{ $pembayaran->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect_url) {
                            // Buka di tab baru
                            window.open(data.redirect_url, '_blank');
                            
                            // Atau redirect langsung (pilih salah satu)
                            // window.location.href = data.redirect_url;
                            
                            payButton.disabled = false;
                            payButton.innerHTML = `
                                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Lanjutkan ke Pembayaran
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mendapatkan URL pembayaran');
                        location.reload();
                    });
            }
        });
    });
</script>
@endpush