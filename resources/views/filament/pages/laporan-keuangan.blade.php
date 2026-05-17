<x-filament-panels::page>
    <div class="space-y-6">
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

        <div class="grid gap-4 md:grid-cols-3">
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
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-xl border bg-white p-4">
                <h2 class="mb-4 text-lg font-bold">Dana Masuk</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b text-left">
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Jenis</th>
                                <th class="py-2">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->danaMasuks as $row)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-2">{{ $row->tanggal?->format('d M Y') }}</td>
                                    <td class="py-2">{{ $row->jenis_label }}</td>
                                    <td class="py-2">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-3 text-gray-500">Belum ada dana masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded-xl border bg-white p-4">
                <h2 class="mb-4 text-lg font-bold">Dana Keluar</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b text-left">
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Jenis</th>
                                <th class="py-2">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->danaKeluars as $row)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-2">{{ $row->tanggal?->format('d M Y') }}</td>
                                    <td class="py-2">{{ $row->jenis_label }}</td>
                                    <td class="py-2">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-3 text-gray-500">Belum ada dana keluar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-filament-panels::page>
