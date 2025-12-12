<div class="space-y-6">

    <h2 class="text-xl font-bold">Detail Alat yang Dipinjam :</h2>

    <div class="border rounded-xl p-4 shadow-sm bg-white space-y-6">

        @foreach ($record->detailTransaksis as $detail)

            {{-- Block Item Alat --}}
            <div class="space-y-2">

                <h3 class="font-semibold text-lg">
                    {{ $detail->alat->nama_alat }}
                </h3>

                <div class="text-sm space-y-1">
                   
                </div>

            </div>

            {{-- Divider antar item --}}
            @if (!$loop->last)
                <div class="border-t pt-4"></div>
            @endif

        @endforeach

    </div>

</div>
