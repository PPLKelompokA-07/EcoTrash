<x-layouts.app title="Masuk EcoTrash">
    <div class="mx-auto max-w-lg mt-8 mb-12">
        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
            <div class="bg-emerald-600 h-2 w-full"></div>
            
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="mt-2 text-sm font-medium text-slate-500">Silakan masuk untuk melanjutkan akses EcoTrash.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-100 px-4 py-3 text-sm font-bold text-rose-700 animate-pulse">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-at text-sm"></i>
                            </div>
                            <input name="email" type="email" 
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                placeholder="nama@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Kata Sandi</label>
                            <a href="#" class="text-[11px] font-bold text-emerald-600 hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-key text-sm"></i>
                            </div>
                            <input name="password" type="password" 
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm font-medium focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all" 
                                placeholder="********" required>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="group w-full flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-4 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all active:scale-[0.98]">
                            Masuk ke Dashboard
                            <i class="fa-solid fa-paper-plane text-xs transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-10 border-t border-slate-100 pt-6 text-center">
                    <p class="text-sm font-medium text-slate-500">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="ml-1 font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">
                            Daftar Gratis
                        </a>
                    </p>
                </div>
            </div>
        </section>
        
        <div class="mt-8 flex justify-center gap-6">
            <div class="flex items-center gap-2 text-slate-400">
                <i class="fa-solid fa-lock text-[10px]"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest">Secure SSL</span>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <i class="fa-solid fa-shield-heart text-[10px]"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest">Privacy Protected</span>
            </div>
        </div>
    </div>
</x-layouts.app>