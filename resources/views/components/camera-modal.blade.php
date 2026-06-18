<div x-data="cameraModal()" x-show="isOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm" style="display: none;" @open-camera.window="openCamera($event.detail.inputId)">
    <div class="relative w-full h-full max-w-lg bg-surface flex flex-col overflow-hidden shadow-2xl md:rounded-2xl md:h-[80vh] md:max-h-[800px]">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 bg-surface z-10 shadow-sm">
            <h3 class="font-bold text-on-surface">Ambil Foto</h3>
            <button @click="closeCamera()" type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-surface-dim hover:bg-surface-variant text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Camera Area -->
        <div class="relative flex-1 bg-black flex items-center justify-center overflow-hidden">
            <video x-ref="videoElement" autoplay playsinline class="w-full h-full object-cover" x-show="!capturedImage"></video>
            <canvas x-ref="canvasElement" class="hidden"></canvas>
            <img :src="capturedImage" class="w-full h-full object-cover" x-show="capturedImage">
            
            <!-- Loading indicator -->
            <div x-show="isLoading" class="absolute inset-0 flex items-center justify-center bg-black/50 text-white">
                <span class="material-symbols-outlined animate-spin text-4xl">autorenew</span>
            </div>
        </div>

        <!-- Controls -->
        <div class="p-6 bg-surface flex items-center justify-center gap-6">
            <template x-if="!capturedImage">
                <button @click="capture()" type="button" class="w-20 h-20 rounded-full bg-primary flex items-center justify-center text-white shadow-lg hover:scale-105 active:scale-95 transition-all outline outline-4 outline-offset-4 outline-primary/30">
                    <span class="material-symbols-outlined text-[36px]">photo_camera</span>
                </button>
            </template>
            <template x-if="capturedImage">
                <div class="flex w-full gap-4">
                    <button @click="retake()" type="button" class="flex-1 py-3 px-4 rounded-xl bg-surface-variant text-on-surface-variant font-bold hover:bg-outline-variant transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">replay</span>
                        Ulangi
                    </button>
                    <button @click="accept()" type="button" class="flex-1 py-3 px-4 rounded-xl bg-primary text-white font-bold hover:bg-primary-dark transition-colors flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <span class="material-symbols-outlined">check</span>
                        Gunakan Foto
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cameraModal', () => ({
        isOpen: false,
        stream: null,
        capturedImage: null,
        targetInputId: null,
        isLoading: false,

        async openCamera(inputId) {
            this.targetInputId = inputId;
            this.isOpen = true;
            this.capturedImage = null;
            this.isLoading = true;

            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: "environment" },
                    audio: false 
                });
                this.$refs.videoElement.srcObject = this.stream;
            } catch (err) {
                console.error("Gagal mengakses kamera:", err);
                alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin di browser.");
                this.closeCamera();
            } finally {
                this.isLoading = false;
            }
        },

        closeCamera() {
            this.isOpen = false;
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.capturedImage = null;
        },

        capture() {
            const video = this.$refs.videoElement;
            const canvas = this.$refs.canvasElement;
            const context = canvas.getContext('2d');

            let width = video.videoWidth;
            let height = video.videoHeight;
            const max_dimension = 800;

            if (width > height) {
                if (width > max_dimension) {
                    height *= max_dimension / width;
                    width = max_dimension;
                }
            } else {
                if (height > max_dimension) {
                    width *= max_dimension / height;
                    height = max_dimension;
                }
            }

            // Set canvas dimensions
            canvas.width = width;
            canvas.height = height;

            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Get image data as JPEG (quality 0.7 for quick preview/client side compression)
            this.capturedImage = canvas.toDataURL('image/jpeg', 0.7);
        },

        retake() {
            this.capturedImage = null;
        },

        accept() {
            if (!this.targetInputId || !this.capturedImage) return;

            const inputElement = document.getElementById(this.targetInputId);
            if (inputElement) {
                // Convert DataURL to File object
                fetch(this.capturedImage)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], "camera_capture.jpg", { type: "image/jpeg" });
                        
                        // Use DataTransfer to put file into input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        inputElement.files = dataTransfer.files;

                        // Trigger change event so alpine/js can catch it
                        inputElement.dispatchEvent(new Event('change', { bubbles: true }));
                        
                        // Trigger toast
                        this.$dispatch('show-toast', { message: 'Foto berhasil ditangkap', type: 'success' });
                        
                        this.closeCamera();
                    });
            } else {
                this.closeCamera();
            }
        }
    }));
});
</script>
