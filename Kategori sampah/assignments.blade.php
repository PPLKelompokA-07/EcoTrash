<x-layouts.app title="Admin - Assign Petugas">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Dashboard Admin
        </a>
    </div>

    <section class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
        <div class="bg-emerald-600 h-2 w-full"></div>
        
        <div class="p-8 sm:p-10">
            <div class="mb-8 flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-people-arrows text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Delegasi Tugas</h2>
                    <p class="text-sm font-medium text-slate-500">Hubungkan referensi kerja dengan petugas lapangan yang tersedia.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.assignments.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="ml-1 text-[11px] font-black uppercase tracking-widest text-slate-400">Pilih Referensi Tugas (Order/Report)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-clipboard-list text-sm"></i>
                            </div>
                            <select name="target_ref" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-10 py-4 text-sm font-bold focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" required>
                                <option value="" disabled selected>Pilih kode referensi...</option>
                                <optgroup label="📦 ORDER (Penjemputan)">
                                    @foreach($orders as $order)
                                        <option value="order:{{ $order->id }}">📦 Order {{ $order->code }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="🚩 REPORT (Laporan Masalah)">
                                    @foreach($reports as $report)
                                        <option value="report:{{ $report->id }}">🚩 Report {{ $report->code }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="ml-1 text-[11px] font-black uppercase tracking-widest text-slate-400">Pilih Petugas Lapangan</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-user-gear text-sm"></i>
                            </div>
                            <select name="petugas_id" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-10 py-4 text-sm font-bold focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" required>
                                <option value="" disabled selected>Pilih nama petugas...</option>
                                @foreach($petugas as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="group w-full flex items-center justify-center gap-3 rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-[0.98]">
                        <i class="fa-solid fa-paper-plane text-xs transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                        Kirim Penugasan Sekarang
                    </button>
                    <p class="mt-4 text-center text-[11px] font-medium text-slate-400 italic">
                        *Petugas akan mendapatkan notifikasi tugas baru di dashboard mereka segera setelah Anda mengklik tombol di atas.
                    </p>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app>