<x-layouts.app title="User - Pemesanan Pengangkutan">
    <nav class="mb-6 flex space-x-1 rounded-xl bg-slate-200/60 p-1">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-white/50 hover:text-slate-900 transition">
            <i class="fa-solid fa-house-chimney text-xs"></i> Dashboard
        </a>
        <a href="{{ route('user.orders') }}" class="flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-bold text-emerald-700 shadow-sm transition">
            <i class="fa-solid fa-truck text-xs"></i> Pemesanan
        </a>
        <a href="{{ route('user.reports') }}" class="flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-white/50 hover:text-slate-900 transition">
            <i class="fa-solid fa-bullhorn text-xs"></i> Pelaporan
        </a>
        <a href="{{ route('user.education') }}" class="flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-white/50 hover:text-slate-900 transition">
            <i class="fa-solid fa-book-open text-xs"></i> Edukasi
        </a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-5">
        <section class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <div class="mb-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">Form Pemesanan</h2>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-blue-600 ring-1 ring-blue-100">
                            <i class="fa-solid fa-clock"></i> 00.00 - 13.00
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('user.orders.store') }}" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Alamat Penjemputan</label>
                            @if($addresses->isEmpty())
                                <span class="text-[10px] font-bold text-rose-500 animate-pulse">Alamat belum tersedia!</span>
                            @endif
                        </div>
                        <select name="address_id" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition" required>
                            <option value="" disabled {{ $addresses->isEmpty() ? 'selected' : '' }}>-- Pilih Alamat --</option>
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->label }} — {{ $address->address_line }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Kategori</label>
                            <select name="category" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition">
                                <option value="kecil">Kecil (1kg)</option>
                                <option value="sedang" selected>Sedang (1-5kg)</option>
                                <option value="besar">Besar (>5kg)</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Pilih Jadwal</label>
                            <select name="schedule_id" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition" required>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ \Illuminate\Support\Carbon::parse($schedule->schedule_time)->format('H:i') }} ({{ $schedule->schedule_date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4">
                        <div class="flex items-center justify-between text-sm border-emerald-100">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-coins text-amber-500 text-lg"></i>
                                <span class="text-slate-600 font-medium">Saldo EcoCoin: <strong>{{ $coin }}</strong></span>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" name="use_coin" value="1" class="peer sr-only" {{ $coin <= 0 ? 'disabled' : '' }}>
                                <div class="peer h-5 w-9 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-emerald-500 peer-checked:after:translate-x-full"></div>
                                <span class="ml-2 text-xs font-bold text-slate-700">Pakai</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-4 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-[0.98]">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm ring-1 ring-slate-100 border-dashed">
                <div class="mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-emerald-500"></i>
                    <h3 class="text-sm font-bold text-slate-900">Tambah Alamat Baru</h3>
                </div>
                <form method="POST" action="{{ route('user.address.store') }}" class="space-y-3">
                    @csrf
                    <input name="label" type="text" placeholder="Label Alamat (Contoh: Rumah, Kos)" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition" required>
                    <textarea name="address_line" rows="2" placeholder="Tuliskan alamat lengkap Anda..." class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition" required></textarea>
                    <button type="submit" class="w-full rounded-lg bg-white border border-slate-300 py-2 text-[11px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all">
                        Simpan Alamat
                    </button>
                </form>
            </div>
        </section>

        <section class="lg:col-span-3 rounded-2xl border border-slate-200 bg-white p-0 shadow-sm ring-1 ring-slate-100 overflow-hidden">
            </section>
    </div>
</x-layouts.app>