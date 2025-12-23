@extends('layouts.app')

@section('title', 'Riwayat Transaksi - Mapala Senja')

@section('content')

<!-- Transaction History Content -->
<section class="py-28 bg-gradient-to-br from-gray-50 to-amber-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-10 h-10 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Transaksi Saya
            </h1>
            <p class="text-gray-600">Kelola dan pantau semua transaksi penyewaan alat Anda</p>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 border-2 border-blue-200 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Transaksi</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border-2 border-amber-200 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Sedang Dipinjam</p>
                        <p class="text-3xl font-bold text-amber-600">{{ $stats['aktif'] }}</p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border-2 border-green-200 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Selesai</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border-2 border-red-200 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Dibatalkan</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['dibatalkan'] }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl p-6 mb-6 border-2 border-gray-200 shadow-md">
            <form method="GET" action="{{ route('transactions.index') }}" class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2.5 bg-[#1F2937] text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition font-bold shadow-md">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Transactions List --}}
        @if($transactions->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border-2 border-gray-200">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki riwayat transaksi penyewaan alat</p>
                <a href="/#equipment" class="inline-block px-8 py-3 bg-[#EAB308] text-white rounded-lg hover:bg-[#1F2937] transition font-semibold shadow-md">
                    Mulai Sewa Alat
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                <div class="bg-white rounded-xl shadow-md border-2 border-gray-100 hover:border-amber-300 transition overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            {{-- Left: Transaction Info --}}
                            <div class="flex-1 mb-4 lg:mb-0">
                                <div class="flex items-center mb-3">
                                    <div class="bg-amber-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">
                                            Transaksi #{{ $transaction->id }}
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 gap-3 mb-3">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-600">{{ $transaction->tanggal_pinjam->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-600">{{ $transaction->tanggal_pinjam->diffInDays($transaction->tanggal_kembali) }} hari</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <span class="text-gray-600">{{ $transaction->detailTransaksis->count() }} alat</span>
                                    </div>
                                </div>

                                {{-- Equipment preview --}}
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($transaction->detailTransaksis->take(3) as $detail)
                                        <span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold border border-amber-200">
                                            {{ $detail->alat->nama_alat }}
                                        </span>
                                    @endforeach
                                    @if($transaction->detailTransaksis->count() > 3)
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                                            +{{ $transaction->detailTransaksis->count() - 3 }} lainnya
                                        </span>
                                    @endif
                                </div>

                                {{-- Status Badge --}}
                                <div class="flex items-center">
                                    @php
                                        $statusConfig = [
                                            'menunggu_pembayaran' => ['class' => 'bg-yellow-100 text-yellow-800 border-yellow-300', 'label' => 'Menunggu Pembayaran'],
                                            'disetujui' => ['class' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => 'Disetujui'],
                                            'dipinjam' => ['class' => 'bg-purple-100 text-purple-800 border-purple-300', 'label' => 'Sedang Dipinjam'],
                                            'selesai' => ['class' => 'bg-green-100 text-green-800 border-green-300', 'label' => 'Selesai'],
                                            'dibatalkan' => ['class' => 'bg-red-100 text-red-800 border-red-300', 'label' => 'Dibatalkan'],
                                        ];
                                        $status = $statusConfig[$transaction->status] ?? ['class' => 'bg-gray-100 text-gray-800 border-gray-300', 'label' => $transaction->status];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold border-2 {{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>

                                    @if($transaction->pembayaran && $transaction->pembayaran->isSuccess())
                                        <span class="ml-2 inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Lunas
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Right: Price & Actions --}}
                            <div class="lg:text-right lg:ml-6 border-t lg:border-t-0 lg:border-l-2 border-gray-100 pt-4 lg:pt-0 lg:pl-6">
                                <p class="text-sm text-gray-600 mb-1 font-medium">Total Biaya</p>
                                <p class="text-2xl font-bold text-amber-600 mb-4">
                                    Rp {{ number_format($transaction->total_biaya, 0, ',', '.') }}
                                </p>

                                <div class="flex flex-col space-y-2">
                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                       class="px-6 py-2.5 bg-[#EAB308] text-white rounded-lg hover:bg-[#1F2937] transition font-semibold text-center shadow-md">
                                        Lihat Detail
                                    </a>

                                    @if($transaction->status === 'menunggu' && $transaction->pembayaran)
                                        <a href="{{ $transaction->pembayaran->payment_url }}"
                                           class="px-6 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold text-center shadow-md">
                                            Bayar Sekarang
                                        </a>
                                    @endif

                                    @if($transaction->status === 'menunggu')
                                        <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin membatalkan transaksi ini?')"
                                                    class="w-full px-6 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold text-center">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</section>

@endsection