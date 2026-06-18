<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EcoTrash') }} - Petugas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 pb-20" x-data="{
        toast: { show: false, message: '', type: 'success' },
        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3500);
        }
    }" @show-toast.window="showToast($event.detail.message, $event.detail.type || 'success')">
    <div class="min-h-screen max-w-md mx-auto bg-gray-50 shadow-2xl relative overflow-x-hidden">
        
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Bottom Navigation -->
        <x-petugas.bottom-nav />
    </div>
    
    <!-- Global Toast Component -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-2 px-4 py-3 rounded-2xl shadow-xl font-bold text-sm min-w-[280px] max-w-[90vw]"
         :class="{
            'bg-surface text-primary border border-primary/20': toast.type === 'success',
            'bg-red-50 text-red-600 border border-red-200': toast.type === 'error'
         }"
         style="display: none;">
        <span class="material-symbols-outlined" x-text="toast.type === 'success' ? 'check_circle' : 'error'"></span>
        <span x-text="toast.message"></span>
    </div>
    
    <x-camera-modal />
</body>
</html>
