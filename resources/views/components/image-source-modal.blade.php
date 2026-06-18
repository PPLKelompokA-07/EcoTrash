<div 
    x-data="{ 
        open: false,
        inputId: null,
        openModal(event) {
            this.inputId = event.detail.inputId;
            this.open = true;
        },
        closeModal() {
            this.open = false;
        },
        chooseGallery() {
            if (this.inputId) {
                document.getElementById(this.inputId).click();
            }
            this.closeModal();
        },
        openCameraAction() {
            const id = this.inputId;
            this.closeModal();
            // Delay to allow modal to fully close before opening camera
            setTimeout(() => {
                if (id) {
                    window.dispatchEvent(new CustomEvent('open-camera', { detail: { inputId: id } }));
                }
            }, 300);
        },

    }"
    @open-image-source.window="openModal($event)"
    class="relative z-[90]"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    x-show="open"
    x-cloak
>
    <!-- Background backdrop -->
    <div 
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
        @click="closeModal"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div 
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-3xl bg-surface text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm"
                @click.outside="closeModal"
            >
                <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-outline/10 text-center">
                    <h3 class="text-xl font-black text-on-surface mb-2" id="modal-title">Pilih Sumber Foto</h3>
                    <p class="text-sm text-on-surface-variant">Dari mana Anda ingin mengambil foto profil?</p>
                </div>

                <div class="px-4 py-3 sm:flex sm:flex-col sm:px-6 gap-2 bg-surface">
                    <button 
                        type="button" 
                        @click="openCameraAction"
                        class="w-full flex items-center justify-center gap-2 bg-primary text-white font-bold py-3 px-4 rounded-xl hover:bg-primary-dark transition-colors shadow-sm"
                    >
                        <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                        Gunakan Kamera
                    </button>
                    
                    <button 
                        type="button" 
                        @click="chooseGallery"
                        class="w-full flex items-center justify-center gap-2 bg-surface text-on-surface border-2 border-outline/20 font-bold py-3 px-4 rounded-xl hover:bg-surface-variant transition-colors"
                    >
                        <span class="material-symbols-outlined text-[20px]">photo_library</span>
                        Pilih dari Galeri
                    </button>

                    <button 
                        type="button" 
                        @click="closeModal"
                        class="mt-2 w-full flex items-center justify-center gap-2 bg-transparent text-error font-bold py-3 px-4 rounded-xl hover:bg-error/10 transition-colors"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
