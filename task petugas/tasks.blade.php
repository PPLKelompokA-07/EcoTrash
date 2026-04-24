<x-layouts.app title="Petugas - Daftar Tugas">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Tugas Hari Ini</h2>
            <p class="text-sm text-slate-500">Selesaikan tugas sesuai urutan lokasi terdekat.</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 shadow-sm">
            <i class="fa-solid fa-clipboard-check text-xl"></i>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-2 gap-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Tugas</p>
            <p class="text-xl font-black text-slate-900">{{ count($orders) + count($reports) }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Selesai</p>
            <p class="text-xl font-black text-emerald-700">0</p> {{-- Ganti dengan data real jika ada --}}
        </div>
    </div>

    <div class="space-y-4">
        {{-- Loop Pengangkutan --}}
        @foreach($orders as $order)
            <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition active:scale-[0.98]">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-blue-500"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-[10px] font-bold uppercase text-blue-600 ring-1 ring-blue-100">
                                <i class="fa-solid fa-truck-pickup"></i> Pengangkutan
                            </span>
                            <h3 class="text-lg font-bold text-slate-900">#{{ $order->code }}</h3>
                        </div>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-slate-600 font-medium">
                            <i class="fa-solid fa-location-dot w-4 text-slate-400"></i>
                            <span>Address ID: {{ $order->address_id }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-600 font-medium">
                            <i class="fa-solid fa-calendar-day w-4 text-slate-400"></i>
                            <span>Jadwal ID: {{ $order->schedule_id }}</span>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <form method="POST" action="{{ route('petugas.orders.update', $order->id) }}" class="flex-1">
                            @csrf
                            <button class="w-full rounded-xl bg-slate-900 py-3 text-sm font-bold text-white shadow-lg shadow-slate-200 active:bg-slate-800">
                                Update Status
                            </button>
                        </form>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $order->address_id }}" target="_blank" class="flex items-center justify-center rounded-xl border border-slate-200 px-4 text-slate-600 hover:bg-slate-50">
                            <i class="fa-solid fa-route"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach

        {{-- Loop Laporan --}}
        @foreach($reports as $report)
            <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition active:scale-[0.98]">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-orange-500"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <span class="inline-flex items-center gap-1 rounded-md bg-orange-50 px-2 py-0.5 text-[10px] font-bold uppercase text-orange-600 ring-1 ring-orange-100">
                                <i class="fa-solid fa-circle-exclamation"></i> Laporan Liar
                            </span>
                            <h3 class="text-lg font-bold text-slate-900">#{{ $report->code }}</h3>
                        </div>
                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-bold text-sky-700">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-slate-500 italic mb-3">"{{ Str::limit($report->description ?? 'Tidak ada deskripsi', 80) }}"</p>
                        <div class="flex items-center gap-3 text-sm text-slate-600 font-bold">
                            <i class="fa-solid fa-map-pin w-4 text-orange-500 text-lg"></i>
                            <span class="text-xs">{{ $report->latitude }}, {{ $report->longitude }}</span>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <form method="POST" action="{{ route('petugas.reports.update', $report->id) }}" class="flex-1">
                            @csrf
                            <button class="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-100 active:bg-emerald-700">
                                Tandai Selesai
                            </button>
                        </form>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $report->latitude }},{{ $report->longitude }}" target="_blank" class="flex items-center justify-center rounded-xl border border-slate-200 px-4 text-slate-600 hover:bg-slate-50">
                            <i class="fa-solid fa-diamond-turn-right"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    @if(count($orders) == 0 && count($reports) == 0)
        <div class="mt-20 flex flex-col items-center justify-center text-center">
            <div class="mb-4 rounded-full bg-slate-100 p-6">
                <i class="fa-solid fa-mug-hot text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Semua Beres!</h3>
            <p class="text-sm text-slate-500">Tidak ada tugas tersisa untuk saat ini.</p>
        </div>
    @endif
</x-layouts.app>