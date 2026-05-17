<x-filament-panels::page>
    <style>
        .finance-report {
            display: grid;
            gap: 1.5rem;
        }

        .finance-hero,
        .finance-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 12px 28px rgba(15, 23, 42, .06);
        }

        .finance-hero {
            padding: 1.5rem;
            background:
                radial-gradient(circle at top right, rgba(234, 179, 8, .22), transparent 30%),
                linear-gradient(135deg, #111827 0%, #1f2937 62%, #78350f 100%);
            color: #fff;
        }

        .finance-hero-top {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .finance-eyebrow {
            color: #fde68a;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .finance-hero h2 {
            margin: .35rem 0 0;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .finance-hero p {
            margin: .35rem 0 0;
            color: rgba(255, 255, 255, .74);
        }

        .finance-filter {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
            min-width: min(100%, 22rem);
        }

        .finance-filter label {
            display: block;
            margin-bottom: .35rem;
            color: rgba(255, 255, 255, .8);
            font-size: .78rem;
            font-weight: 600;
        }

        .finance-filter input {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: .8rem;
            background: rgba(255, 255, 255, .1);
            color: #fff;
            padding: .7rem .8rem;
        }

        .finance-filter input::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        .finance-kpis {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .finance-kpi {
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 1rem;
            background: rgba(255, 255, 255, .08);
            padding: 1rem;
            backdrop-filter: blur(8px);
        }

        .finance-kpi span {
            display: block;
            color: rgba(255, 255, 255, .72);
            font-size: .78rem;
        }

        .finance-kpi strong {
            display: block;
            margin-top: .35rem;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .finance-kpi small {
            display: block;
            margin-top: .35rem;
            color: rgba(255, 255, 255, .58);
        }

        .finance-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .finance-panel {
            padding: 1.25rem;
        }

        .finance-panel-head {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .finance-panel h3 {
            margin: 0;
            color: #111827;
            font-size: 1rem;
            font-weight: 800;
        }

        .finance-panel p {
            margin: .25rem 0 0;
            color: #6b7280;
            font-size: .82rem;
        }

        .summary-list {
            display: grid;
            gap: .75rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            border-bottom: 1px dashed #e5e7eb;
            padding-bottom: .75rem;
        }

        .summary-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            color: #374151;
            font-weight: 600;
        }

        .summary-value {
            font-weight: 800;
        }

        .summary-value.in {
            color: #15803d;
        }

        .summary-value.out {
            color: #b91c1c;
        }

        .finance-table-wrap {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
        }

        .finance-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        .finance-table thead {
            background: #f9fafb;
        }

        .finance-table th {
            color: #4b5563;
            font-size: .74rem;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .finance-table th,
        .finance-table td {
            padding: .95rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            text-align: left;
            vertical-align: top;
        }

        .finance-table tbody tr:hover {
            background: #fffbeb;
        }

        .finance-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .money {
            text-align: right !important;
            white-space: nowrap;
            font-weight: 800;
        }

        .money.in {
            color: #15803d;
        }

        .money.out {
            color: #b91c1c;
        }

        .cash-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: .28rem .6rem;
            font-size: .72rem;
            font-weight: 800;
        }

        .cash-badge.in {
            background: #dcfce7;
            color: #166534;
        }

        .cash-badge.out {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            color: #6b7280;
            font-size: .9rem;
        }

        @media (max-width: 1024px) {
            .finance-kpis {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .finance-grid,
            .finance-filter,
            .finance-kpis {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="finance-report">
        <section class="finance-hero">
            <div class="finance-hero-top">
                <div>
                    <div class="finance-eyebrow">Financial Overview</div>
                    <h2>Laporan Keuangan</h2>
                    <p>Ringkasan pemasukan, pengeluaran, dan saldo kas organisasi.</p>
                </div>

                <div class="finance-filter">
                    <div>
                        <label>Dari Tanggal</label>
                        <input type="date" wire:model.live="dari">
                    </div>
                    <div>
                        <label>Sampai Tanggal</label>
                        <input type="date" wire:model.live="sampai">
                    </div>
                </div>
            </div>

            <div class="finance-kpis">
                <div class="finance-kpi">
                    <span>Total Pemasukan</span>
                    <strong>Rp {{ number_format($this->totalPemasukan, 0, ',', '.') }}</strong>
                    <small>Dana masuk disetujui</small>
                </div>
                <div class="finance-kpi">
                    <span>Total Pengeluaran</span>
                    <strong>Rp {{ number_format($this->totalPengeluaran, 0, ',', '.') }}</strong>
                    <small>Pengeluaran tercatat</small>
                </div>
                <div class="finance-kpi">
                    <span>Saldo Akhir</span>
                    <strong>Rp {{ number_format($this->saldo, 0, ',', '.') }}</strong>
                    <small>Pemasukan - pengeluaran</small>
                </div>
                <div class="finance-kpi">
                    <span>Jumlah Transaksi</span>
                    <strong>{{ $this->jumlahTransaksi }}</strong>
                    <small>Aktivitas dalam periode</small>
                </div>
            </div>
        </section>

        <div class="finance-grid">
            <section class="finance-panel">
                <div class="finance-panel-head">
                    <div>
                        <h3>Komposisi Pemasukan</h3>
                        <p>Distribusi dana masuk berdasarkan sumber.</p>
                    </div>
                </div>

                <div class="summary-list">
                    @forelse ($this->ringkasanPemasukan as $row)
                        <div class="summary-row">
                            <span class="summary-label">{{ \App\Models\DanaMasuk::JENIS[$row->jenis] ?? ucfirst($row->jenis) }}</span>
                            <span class="summary-value in">Rp {{ number_format($row->total, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="empty-state">Belum ada pemasukan pada periode ini.</p>
                    @endforelse
                </div>
            </section>

            <section class="finance-panel">
                <div class="finance-panel-head">
                    <div>
                        <h3>Komposisi Pengeluaran</h3>
                        <p>Distribusi dana keluar berdasarkan kebutuhan.</p>
                    </div>
                </div>

                <div class="summary-list">
                    @forelse ($this->ringkasanPengeluaran as $row)
                        <div class="summary-row">
                            <span class="summary-label">{{ \App\Models\DanaKeluar::JENIS[$row->jenis] ?? ucfirst($row->jenis) }}</span>
                            <span class="summary-value out">Rp {{ number_format($row->total, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="empty-state">Belum ada pengeluaran pada periode ini.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="finance-panel">
            <div class="finance-panel-head">
                <div>
                    <h3>Arus Kas</h3>
                    <p>Riwayat pemasukan dan pengeluaran dalam satu tabel kronologis.</p>
                </div>
            </div>

            <div class="finance-table-wrap">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th class="money">Nominal</th>
                            <th class="money">Saldo Berjalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->arusKas as $row)
                            <tr>
                                <td>{{ $row['tanggal']?->format('d M Y') }}</td>
                                <td>
                                    <span class="cash-badge {{ $row['tipe'] === 'masuk' ? 'in' : 'out' }}">
                                        {{ $row['tipe'] === 'masuk' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td>{{ $row['jenis'] }}</td>
                                <td>{{ $row['keterangan'] ?: '-' }}</td>
                                <td class="money {{ $row['tipe'] === 'masuk' ? 'in' : 'out' }}">
                                    {{ $row['tipe'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($row['nominal'], 0, ',', '.') }}
                                </td>
                                <td class="money">Rp {{ number_format($row['saldo_berjalan'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">Belum ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>
