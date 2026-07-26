<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-red-600">Ruang kerja Waprofit</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Dashboard</h1>
            </div>
            <a href="#" class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M12 5v14m-7-7h14" /></svg>
                Buat baru
            </a>
        </div>
    </x-slot>

    <div class="bg-slate-50 py-6 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-600 to-red-800 px-6 py-7 text-white shadow-xl shadow-red-600/20 sm:px-8 sm:py-9">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-medium ring-1 ring-inset ring-white/20">Operasional jadi lebih rapi</span>
                    <h2 class="mt-4 text-2xl font-semibold tracking-tight sm:text-3xl">Mulai pekerjaan Anda hari ini.</h2>
                    <p class="mt-2 text-sm leading-6 text-red-100 sm:text-base">Buat kalkulasi pajak dan dokumen operasional dalam satu ruang kerja yang praktis.</p>
                </div>
            </section>

            <section class="grid gap-4 sm:grid-cols-3">
                <!-- todo: implementasikan fitur kalkulator dibawh ini sesuai file PRD.md -->
                <a href="{{ route('calculator.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v18m0-13.5h12.5l-1.5 3 1.5 3H3.75" /></svg></span>
                    <h3 class="mt-4 font-semibold text-slate-900">Kalkulasi Baru</h3>
                    <p class="mt-1 text-sm leading-5 text-slate-500">Hitung PPN, PPh 23, fee, dan estimasi laba.</p>
                </a>
                <a href="#" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5l-5.25-5.25Z" /><path stroke-linecap="round" d="M8.25 12h7.5m-7.5 3h7.5" /></svg></span>
                    <h3 class="mt-4 font-semibold text-slate-900">Dokumen Baru</h3>
                    <p class="mt-1 text-sm leading-5 text-slate-500">Buat dokumen formal dari template siap pakai.</p>
                </a>
                <a href="#" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a8.25 8.25 0 1 0 0 16.5 8.25 8.25 0 0 0 0-16.5ZM12 8.25v3.75l2.25 1.5" /></svg></span>
                    <h3 class="mt-4 font-semibold text-slate-900">Template</h3>
                    <p class="mt-1 text-sm leading-5 text-slate-500">Pilih, gunakan, atau kelola template company.</p>
                </a>
            </section>

            <section class="grid gap-6 lg:grid-cols-5">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-3 sm:p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div><h2 class="text-lg font-semibold text-slate-900">Dokumen terbaru</h2><p class="mt-1 text-sm text-slate-500">Akses kembali pekerjaan terakhir Anda.</p></div>
                        <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Lihat semua</a>
                    </div>
                    <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100">
                        <a href="#" class="flex items-center gap-4 py-4 transition hover:bg-slate-50">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5l-5.25-5.25Z" /><path stroke-linecap="round" d="M8.25 12h7.5" /></svg></span>
                            <span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold text-slate-800">Invoice PT Samudera Indonesia</span><span class="mt-0.5 block text-xs text-slate-500">Diperbarui hari ini, 10.30</span></span><span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Draf</span>
                        </a>
                        <a href="#" class="flex items-center gap-4 py-4 transition hover:bg-slate-50">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25-2.25V7.5l-5.25-5.25Z" /><path stroke-linecap="round" d="M8.25 12h7.5" /></svg></span>
                            <span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold text-slate-800">Shipping Instruction MV. Nusantara</span><span class="mt-0.5 block text-xs text-slate-500">Diperbarui kemarin, 14.12</span></span><span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Final</span>
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2 sm:p-6">
                    <div class="flex items-center justify-between gap-4"><div><h2 class="text-lg font-semibold text-slate-900">Kalkulasi terbaru</h2><p class="mt-1 text-sm text-slate-500">Ringkasan transaksi terakhir.</p></div><a href="#" class="text-sm font-semibold text-red-600 hover:text-red-800">Lihat semua</a></div>
                    <div class="mt-5 space-y-3">
                        <a href="#" class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-red-50"><span class="flex items-center justify-between gap-3"><span class="text-sm font-semibold text-slate-800">Brokerage MV. Meratus</span><span class="text-xs text-slate-500">Hari ini</span></span><span class="mt-2 flex items-end justify-between gap-3"><span class="text-xs text-slate-500">Estimasi laba bersih</span><span class="text-sm font-semibold text-emerald-700">Rp12.450.000</span></span></a>
                        <a href="#" class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-red-50"><span class="flex items-center justify-between gap-3"><span class="text-sm font-semibold text-slate-800">Charter PT Laut Biru</span><span class="text-xs text-slate-500">Kemarin</span></span><span class="mt-2 flex items-end justify-between gap-3"><span class="text-xs text-slate-500">Estimasi laba bersih</span><span class="text-sm font-semibold text-emerald-700">Rp8.275.000</span></span></a>
                    </div>
                </div>
            </section>

            <section class="flex gap-4 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-amber-900" role="status">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.949 3.374H4.646c-1.732 0-2.815-1.874-1.949-3.374L10.05 3.374c.866-1.5 3.032-1.5 3.898 0l7.355 12.752ZM12 16.5h.008v.008H12V16.5Z" /></svg>
                <p class="text-sm leading-6"><span class="font-semibold">Pengingat retensi:</span> Data dokumen dan kalkulasi akan dihapus permanen setelah 3 bulan. Pastikan Anda mengunduh arsip penting sebelum masa simpan berakhir.</p>
            </section>
        </div>
    </div>
</x-app-layout>
