<x-layouts.app title="Admin - Monitoring Pengangkutan">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-emerald-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <h2 class="mt-2 text-2xl font-black text-slate-900 tracking-tight">Monitoring Pengangkutan</h2>
            <p class="text-sm font-medium text-slate-500">Pantau status penjemputan sampah organik dan anorganik secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.location.reload()" class="flex h-11 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-bold text-slate-600 shadow-sm hover:bg-slate-50 transition-all">
                <i class="fa-solid fa-rotate text-xs"></i> Refresh Data
            </button>
        </div>
    </div>

    {{-- STATISTIK REAL-TIME --}}
    <div class="mb-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Order</p>
            <p class="text-xl font-black text-slate-900">{{ $orders->count() }}</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">Dalam Proses</p>
            <p class="text-xl font-black text-blue-700">{{ $orders->where('status', 'diproses')->count() }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600">Selesai</p>
            <p class="text-xl font-black text-emerald-700">{{ $orders->where('status', 'selesai')->count() }}</p>
        </div>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-amber-600">Pending</p>
            <p class="text-xl font-black text-amber-700">{{ $orders->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm ring-1 ring-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 bg-slate-50/50">
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Kategori Sampah</th>
                        <th class="px-6 py-4">Detail Jadwal</th>
                        <th class="px-6 py-4">Status Pengangkutan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                                        <i class="fa-solid fa-receipt text-xs"></i>
                                    </div>
                                    <span class="font-bold text-slate-900 uppercase">#{{ $order->code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $categoryColor = match(strtolower($order->category)) {
                                        'organik' => 'text-emerald-600 bg-emerald-50 ring-emerald-100',
                                        'anorganik' => 'text-blue-600 bg-blue-50 ring-blue-100',
                                        default => 'text-slate-600 bg-slate-50 ring-slate-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[10px] font-black uppercase ring-1 {{ $categoryColor }}">
                                    <i class="fa-solid fa-box-open"></i>
                                    {{ $order->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <p class="font-bold text-slate-700">Slot ID: {{ $order->schedule_id }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium italic">Diproses oleh sistem operasional</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusStyle = match(strtolower($order->status)) {
                                        'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                        'diproses' => 'bg-sky-100 text-sky-700 ring-sky-200',
                                        'selesai' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                        'dibatalkan' => 'bg-rose-100 text-rose-700 ring-rose-200',
                                        default => 'bg-slate-100 text-slate-600 ring-slate-200'
                                    };
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full animate-pulse {{ str_contains($statusStyle, 'emerald') ? 'bg-emerald-500' : (str_contains($statusStyle, 'amber') ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wide ring-1 {{ $statusStyle }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- Aksi Admin (Bisa tambah tombol detail/update status) --}}
                                <button class="rounded-lg bg-slate-900 px-3 py-1.5 text-[11px] font-bold text-white hover:bg-slate-800 transition-all">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-truck-fast text-4xl text-slate-200 mb-3"></i>
                                    <h3 class="font-bold text-slate-900">Belum ada pengangkutan</h3>
                                    <p class="text-xs text-slate-500">Semua pesanan penjemputan akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.app>