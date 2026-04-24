<x-layouts.app title="Daftar EcoTrash">
    <div class="mx-auto max-w-lg mt-4 mb-12">
        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
            <div class="bg-emerald-600 h-2 w-full"></div>
            
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <i class="fa-solid fa-user-plus text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Akun</h2>
                    <p class="mt-2 text-sm font-medium text-slate-500">Bergabunglah bersama kami untuk lingkungan yang lebih bersih.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-100 px-4 py-3 text-sm font-bold text-rose-700 animate-pulse">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-id-card text-sm"></i>
                            </div>
                            <input name="name" type="text" 
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Email Aktif</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </div>
                            <input name="email" type="email" 
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                placeholder="contoh@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input name="password" type="password" 
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                    placeholder="Min. 6 karakter" required>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Ulangi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                    <i class="fa-solid fa-shield-check text-sm"></i>
                                </div>
                                <input name="password_confirmation" type="password" 
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                    placeholder="Konfirmasi" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="group w-full flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-4 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all active:scale-[0.98]">
                            Buat Akun Sekarang
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-10 border-t border-slate-100 pt-6 text-center">
                    <p class="text-sm font-medium text-slate-500">
                        Sudah menjadi bagian dari kami?
                        <a href="{{ route('login') }}" class="ml-1 font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">
                            Masuk ke Akun
                        </a>
                    </p>
                </div>
            </div>
        </section>
        
        <p class="mt-6 text-center text-[11px] leading-relaxed text-slate-400">
            Dengan mendaftar, Anda menyetujui <span class="font-bold underline">Syarat & Ketentuan</span> serta <span class="font-bold underline">Kebijakan Privasi</span> EcoTrash yang berlaku.
        </p>
    </div>
</x-layouts.app>