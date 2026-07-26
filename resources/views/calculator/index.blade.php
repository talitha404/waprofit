<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-red-600">Ruang kerja Waprofit</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Kalkulator Profit Riil</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex min-h-11 items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-red-200 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Kembali</a>
        </div>
    </x-slot>

    <div class="bg-slate-50 py-6 sm:py-8" x-data="profitCalculator()" x-cloak>
        <form method="POST" action="{{ route('calculator.pdf') }}" class="mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8" x-ref="form">
            @csrf

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Periksa kembali data kalkulasi.</p>
                    <ul class="mt-1 list-disc pl-5"><li>{{ $errors->first() }}</li></ul>
                </div>
            @endif

            <div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-br from-red-600 to-red-800 px-6 py-7 text-white shadow-xl shadow-red-600/20 sm:px-8">
                <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-medium ring-1 ring-inset ring-white/20">Estimasi operasional</span>
                <p class="mt-3 max-w-3xl text-sm leading-6 text-red-100">Preview diperbarui langsung di perangkat Anda. Hasil resmi dihitung ulang di server saat PDF dibuat. Tarif tetap: PPN 11% dan PPh 23 2%.</p>
            </div>

            <div class="grid gap-6 xl:grid-cols-5">
                <div class="space-y-6 xl:col-span-3">
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div><h2 class="text-lg font-semibold text-slate-900">Data transaksi</h2><p class="mt-1 text-sm text-slate-500">Masukkan DPP client dan vendor untuk menghitung selisih transaksi.</p></div>
                        <div class="mt-5"><label for="title" class="text-sm font-medium text-slate-700">Judul kalkulasi <span class="font-normal text-slate-400">(opsional)</span></label><input id="title" name="title" value="{{ old('title') }}" maxlength="120" class="mt-1.5 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Contoh: Brokerage MV. Nusantara"></div>
                        <div class="mt-6 grid gap-5 lg:grid-cols-2">
                            <fieldset class="rounded-2xl border border-slate-200 p-4"><legend class="px-1 text-sm font-semibold text-slate-900">Client / Pemilik Barang</legend><div class="mt-2"><label class="text-sm text-slate-600" for="client_name">Nama pihak</label><input id="client_name" name="client_name" value="{{ old('client_name') }}" class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Opsional"></div><div class="mt-4"><label class="text-sm text-slate-600" for="client_dpp">DPP (Rp)</label><input id="client_dpp" name="client_dpp" x-model="clientDpp" value="{{ old('client_dpp', '0') }}" type="number" min="0" step="0.01" inputmode="decimal" required class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"></div><label class="mt-4 flex min-h-11 cursor-pointer items-center gap-3 rounded-xl bg-red-50 px-3 text-sm font-medium text-slate-700"><input type="hidden" name="client_ppn_enabled" value="0"><input name="client_ppn_enabled" x-model="clientPpn" type="checkbox" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500"> Kenakan PPN 11%</label></fieldset>
                            <fieldset class="rounded-2xl border border-slate-200 p-4"><legend class="px-1 text-sm font-semibold text-slate-900">Vendor / Pemilik Kapal</legend><div class="mt-2"><label class="text-sm text-slate-600" for="vendor_name">Nama pihak</label><input id="vendor_name" name="vendor_name" value="{{ old('vendor_name') }}" class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Opsional"></div><div class="mt-4"><label class="text-sm text-slate-600" for="vendor_dpp">DPP (Rp)</label><input id="vendor_dpp" name="vendor_dpp" x-model="vendorDpp" value="{{ old('vendor_dpp', '0') }}" type="number" min="0" step="0.01" inputmode="decimal" required class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"></div><label class="mt-4 flex min-h-11 cursor-pointer items-center gap-3 rounded-xl bg-red-50 px-3 text-sm font-medium text-slate-700"><input type="hidden" name="vendor_ppn_enabled" value="0"><input name="vendor_ppn_enabled" x-model="vendorPpn" type="checkbox" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500"> Kenakan PPN 11%</label></fieldset>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex items-start justify-between gap-4"><div><h2 class="text-lg font-semibold text-slate-900">Fee broker jaringan</h2><p class="mt-1 text-sm text-slate-500">Fee persentase dihitung dari selisih DPP.</p></div><button type="button" @click="addBroker()" class="inline-flex min-h-11 shrink-0 items-center rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">+ Tambah broker</button></div>
                        <template x-if="brokers.length === 0"><div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">Belum ada fee broker. Tambahkan bila transaksi memiliki fee jaringan.</div></template>
                        <div class="mt-5 space-y-4"><template x-for="(broker, index) in brokers" :key="broker.id"><div class="rounded-2xl border border-slate-200 p-4"><div class="flex items-center justify-between gap-4"><p class="text-sm font-semibold text-slate-800" x-text="`Broker ${index + 1}`"></p><button type="button" @click="removeBroker(index)" class="inline-flex min-h-11 items-center rounded-lg px-3 text-sm font-semibold text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">Hapus</button></div><div class="mt-3 grid gap-4 sm:grid-cols-2"><div><label class="text-sm text-slate-600">Nama broker</label><input :name="`brokers[${index}][name]`" x-model="broker.name" class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Opsional"></div><div><label class="text-sm text-slate-600">Jenis fee</label><select :name="`brokers[${index}][fee_type]`" x-model="broker.fee_type" class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"><option value="nominal">Nominal (Rp)</option><option value="persentase">Persentase (%)</option></select></div><div><label class="text-sm text-slate-600">Nilai fee</label><input :name="`brokers[${index}][fee_value]`" x-model="broker.fee_value" type="number" min="0" step="0.01" inputmode="decimal" required class="mt-1 block min-h-11 w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"></div><label class="flex min-h-11 cursor-pointer items-center gap-3 self-end rounded-xl bg-red-50 px-3 text-sm font-medium text-slate-700"><input type="hidden" :name="`brokers[${index}][pph_23_enabled]`" value="0"><input :name="`brokers[${index}][pph_23_enabled]`" x-model="broker.pph_23_enabled" type="checkbox" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500"> Potong PPh 23 (2%)</label></div></div></template></div>
                    </section>
                </div>

                <aside class="xl:col-span-2"><section class="sticky top-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"><div class="flex items-start justify-between gap-4"><div><h2 class="text-lg font-semibold text-slate-900">Preview perhitungan</h2><p class="mt-1 text-sm text-slate-500">Estimasi sebelum generate PDF.</p></div><span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="ppnPosition > 0 ? 'bg-amber-50 text-amber-700' : (ppnPosition < 0 ? 'bg-sky-50 text-sky-700' : 'bg-slate-100 text-slate-600')" x-text="ppnLabel"></span></div><div class="mt-5 space-y-3 text-sm"><div class="flex justify-between gap-4"><span class="text-slate-500">Selisih DPP</span><strong class="text-slate-900" x-text="rupiah(dppDifference)"></strong></div><div class="flex justify-between gap-4"><span class="text-slate-500">PPN keluaran</span><strong x-text="rupiah(ppnOutput)"></strong></div><div class="flex justify-between gap-4"><span class="text-slate-500">PPN masukan</span><strong x-text="rupiah(ppnInput)"></strong></div><div class="flex justify-between gap-4"><span class="text-slate-500">Posisi PPN</span><strong x-text="rupiah(ppnPosition)"></strong></div><div class="border-t border-slate-100 pt-3"><div class="flex justify-between gap-4"><span class="text-slate-500">PPh 23 penerimaan (2%)</span><strong x-text="rupiah(pphReceive)"></strong></div><div class="mt-2 flex justify-between gap-4"><span class="text-slate-500">PPh 23 vendor (2%)</span><strong x-text="rupiah(pphVendor)"></strong></div></div><div class="border-t border-slate-100 pt-3"><div class="flex justify-between gap-4"><span class="text-slate-500">Total fee bruto</span><strong x-text="rupiah(totalGrossFee)"></strong></div><div class="mt-2 flex justify-between gap-4"><span class="text-slate-500">Total PPh broker</span><strong x-text="rupiah(totalFeeTax)"></strong></div><div class="mt-2 flex justify-between gap-4"><span class="text-slate-500">Total fee netto</span><strong x-text="rupiah(totalNetFee)"></strong></div></div><div class="rounded-2xl bg-emerald-50 p-4"><span class="block text-xs font-medium uppercase tracking-wide text-emerald-700">Estimasi laba bersih</span><strong class="mt-1 block text-xl font-semibold text-emerald-800" x-text="rupiah(netProfit)"></strong></div></div><p x-show="dppDifference < 0" class="mt-4 rounded-xl bg-amber-50 p-3 text-xs leading-5 text-amber-800">Selisih DPP negatif: fee persentase menjadi Rp0 dan transaksi perlu ditinjau.</p><p class="mt-4 text-xs leading-5 text-slate-500">PPh 23 penerimaan dan vendor merupakan informasi estimasi; perlakuan pajak bergantung transaksi. Kalkulator ini bukan nasihat pajak.</p></section></aside>
            </div>

            <div class="fixed inset-x-0 bottom-0 z-20 border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur sm:px-6"><div class="mx-auto flex max-w-7xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-end"><label class="flex min-h-11 items-center gap-3 text-sm font-medium text-slate-700"><input name="save_history" type="checkbox" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500"> Simpan juga sebagai riwayat (3 bulan)</label><button type="submit" formaction="{{ route('calculator.store') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">Simpan riwayat</button><button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Generate PDF</button></div></div>
        </form>
    </div>

    <script>
        function profitCalculator() {
            return {
                clientDpp: @js(old('client_dpp', '0')), vendorDpp: @js(old('vendor_dpp', '0')),
                clientPpn: @js((bool) old('client_ppn_enabled', true)), vendorPpn: @js((bool) old('vendor_ppn_enabled', true)),
                brokers: @js(old('brokers', [])),
                addBroker() { this.brokers.push({ id: Date.now(), name: '', fee_type: 'nominal', fee_value: '0', pph_23_enabled: true }); },
                removeBroker(index) { this.brokers.splice(index, 1); },
                number(value) { const parsed = Number.parseFloat(value); return Number.isFinite(parsed) && parsed >= 0 ? parsed : 0; },
                get dppDifference() { return this.number(this.clientDpp) - this.number(this.vendorDpp); },
                get ppnOutput() { return this.clientPpn ? this.number(this.clientDpp) * .11 : 0; }, get ppnInput() { return this.vendorPpn ? this.number(this.vendorDpp) * .11 : 0; }, get ppnPosition() { return this.ppnOutput - this.ppnInput; }, get pphReceive() { return this.number(this.clientDpp) * .02; }, get pphVendor() { return this.number(this.vendorDpp) * .02; },
                get feeRows() { return this.brokers.map(b => { const gross = b.fee_type === 'persentase' ? Math.max(this.dppDifference, 0) * this.number(b.fee_value) / 100 : this.number(b.fee_value); const tax = b.pph_23_enabled ? gross * .02 : 0; return { gross, tax, net: gross - tax }; }); },
                get totalGrossFee() { return this.feeRows.reduce((sum, fee) => sum + fee.gross, 0); }, get totalFeeTax() { return this.feeRows.reduce((sum, fee) => sum + fee.tax, 0); }, get totalNetFee() { return this.feeRows.reduce((sum, fee) => sum + fee.net, 0); },
                get netProfit() { return this.dppDifference - Math.max(this.ppnPosition, 0) - this.totalNetFee; }, get ppnLabel() { return this.ppnPosition > 0 ? 'Kurang Bayar' : (this.ppnPosition < 0 ? 'Lebih Bayar PPN' : 'Nihil PPN'); },
                rupiah(value) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(Math.round(value)); },
            };
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
