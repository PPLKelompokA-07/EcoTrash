@props(['initialPhoto', 'uploadRoute', 'userInitial'])

<div class="flex flex-col items-center relative" x-data="{
    profileImage: '{{ $initialPhoto }}',
    newPhotoFile: null,
    isUploadingPhoto: false,
    inputId: 'profile_upload_' + Math.random().toString(36).substr(2, 9),
    
    handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Show preview immediately using original file
        this.profileImage = URL.createObjectURL(file);
        
        // Client-side compression
        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;
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

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    this.newPhotoFile = new File([blob], file.name || 'profile.jpg', {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                }, 'image/jpeg', 0.7);
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    },
    
    saveProfilePicture() {
        if (!this.newPhotoFile) return;
        this.isUploadingPhoto = true;
        
        const formData = new FormData();
        formData.append('foto', this.newPhotoFile);
        
        axios.post('{{ $uploadRoute }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            timeout: 60000
        })
        .then(res => {
            this.newPhotoFile = null;
            this.isUploadingPhoto = false;
            
            // Tampilkan keterangan singkat berhasil diunggah
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Foto profil berhasil diganti',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Foto profil berhasil diunggah!');
            }
            this.$dispatch('show-toast', { message: 'Foto profil berhasil diganti' });
        })
        .catch(err => {
            this.isUploadingPhoto = false;
            const data = err.response?.data;
            const msg = data?.message || (data?.errors?.foto ? data.errors.foto[0] : 'Gagal mengunggah foto profil.');
            alert(msg);
        });
    }
}">
    <!-- Circular Avatar Container -->
    <div class="w-28 h-28 md:w-36 md:h-36 mx-auto rounded-full bg-surface flex items-center justify-center text-primary text-5xl md:text-6xl font-black mb-4 border-4 border-white shadow-lg relative z-10 overflow-hidden group">
        <!-- Initial Fallback -->
        <template x-if="!profileImage">
            <span>{{ $userInitial }}</span>
        </template>
        
        <!-- Image View -->
        <template x-if="profileImage">
            <img :src="profileImage" alt="Profile" class="w-full h-full object-cover">
        </template>
        
        <!-- Hover Overlay (Trigger) -->
        <button type="button" @click="$dispatch('open-image-source', { inputId: inputId })" class="absolute inset-0 w-full h-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
            <span class="material-symbols-outlined text-[32px]">photo_camera</span>
        </button>
        
        <!-- Hidden File Input -->
        <input type="file" :id="inputId" accept="image/*" class="hidden" @change="handleImageUpload">
    </div>

    <!-- Save Photo Button -->
    <button x-show="newPhotoFile" style="display: none;" @click="saveProfilePicture()" :disabled="isUploadingPhoto" type="button" class="mb-4 bg-primary text-white font-bold py-2 px-6 rounded-full shadow-md hover:bg-primary-dark hover:-translate-y-0.5 active:translate-y-0 transition-all disabled:opacity-50 flex items-center justify-center gap-2 z-10 relative">
        <span x-show="!isUploadingPhoto" class="material-symbols-outlined text-[18px]">save</span>
        <span x-show="isUploadingPhoto" class="material-symbols-outlined text-[18px] animate-spin">autorenew</span>
        <span x-text="isUploadingPhoto ? 'Menyimpan...' : 'Simpan Foto Profil'"></span>
    </button>
</div>
