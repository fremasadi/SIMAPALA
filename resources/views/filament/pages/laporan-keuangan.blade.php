<x-filament-panels::page>
    <div class="space-y-6">
        <section class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="mb-4">
                <h2 class="text-lg font-bold">Filter Laporan</h2>
                <p class="text-sm text-gray-500">Pilih periode untuk melihat ringkasan dan arus kas.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium">Dari Tanggal</label>
                    <input type="date" wire:model.live="dari" class="w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Sampai Tanggal</label>
                    <input type="date" wire:model.live="sampai" class="w-full rounded-lg border-gray-300">
                </div>
            </div>
        </section>

        <section class="space-y-4">
            <div>
                <h2 class="text-lg font-bold">Overview</h2>
                <p class="text-sm text-gray-500">Ringkasan posisi keuangan pada periode terpilih.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="text-sm text-green-700">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-800">Rp {{ number_format($this->totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="text-sm text-red-700">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-800">Rp {{ number_format($this->totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm text-amber-700">Saldo</p>
                    <p class="text-2xl font-bold text-amber-800">Rp {{ number_format($this->saldo, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-700">Jumlah Transaksi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $this->jumlahTransaksi }}</p>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-xl border bg-white p-4">
                <h2 class="mb-4 text-lg font-bold">Ringkasan Pemasukan</h2>
                <div class="space-y-3">
                    @forelse ($this->ringkasanPemasukan as $row)
                        <div class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                            <span>{{ \App\Models\DanaMasuk::JENIS[$row->jenis] ?? ucfirst($row->jenis) }}</span>
                            <span class="font-semibold text-green-700">Rp {{ number_format($row->total, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada pemasukan pada periode ini.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-xl border bg-white p-4">
                <h2 class="mb-4 text-lg font-bold">Ringkasan Pengeluaran</h2>
                <div class="space-y-3">
                    @forelse ($this->ringkasanPengeluaran as $row)
                        <div class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                            <span>{{ \App\Models\DanaKeluar::JENIS[$row->jenis] ?? ucfirst($row->jenis) }}</span>
                            <span class="font-semibold text-red-700">Rp {{ number_format($row->total, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada pengeluaran pada periode ini.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="rounded-xl border bg-white p-4">
            <div class="mb-4">
                <h2 class="text-lg font-bold">Tabel Arus Kas</h2>
                <p class="text-sm text-gray-500">Gabungan seluruh pemasukan dan pengeluaran sesuai periode.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Tipe</th>
                            <th class="py-2">Jenis</th>
                            <th class="py-2">Keterangan</th>
                            <th class="py-2 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->arusKas as $row)
                            <tr class="border-b last:border-b-0">
                                <td class="py-2">{{ $row['tanggal']?->format('d M Y') }}</td>
                                <td class="py-2">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $row['tipe'] === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $row['tipe'] === 'masuk' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-2">{{ $row['jenis'] }}</td>
                                <td class="py-2">{{ $row['keterangan'] ?: '-' }}</td>
                                <td class="py-2 text-right font-semibold {{ $row['tipe'] === 'masuk' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $row['tipe'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($row['nominal'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">Belum ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>
