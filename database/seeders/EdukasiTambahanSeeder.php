<?php

namespace Database\Seeders;

use App\Models\ArtikelEdukasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class EdukasiTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari admin untuk ditugaskan sebagai penulis
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->error('Tidak ada user Admin ditemukan. Silakan jalankan UsersTableSeeder dulu.');
            return;
        }

        $artikels = [
            [
                'judul' => 'Cara Mudah Memulai Daur Ulang Kertas di Rumah',
                'kategori' => 'daur_ulang',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Langkah Awal Daur Ulang Kertas</h2><p>Mendaur ulang kertas di rumah adalah langkah kecil yang berdampak besar. Mulailah dengan menyediakan tempat sampah khusus kertas. Pastikan kertas tidak basah atau berminyak. Kertas kardus, koran, dan HVS bekas bisa disalurkan ke bank sampah atau dijadikan bubur kertas untuk kerajinan tangan.</p>',
            ],
            [
                'judul' => 'Membuat Kompos dari Sisa Dapur dalam 30 Hari',
                'kategori' => 'kompos',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1590682680695-43b964a3ae17?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Ubah Sisa Dapur Jadi Emas Hitam</h2><p>Daripada membuang sisa sayur dan kulit buah, ubahlah menjadi kompos! Siapkan wadah bertutup, lalu campurkan sisa sayuran (hijau) dengan daun kering/kardus (cokelat). Aduk setiap 3 hari sekali dan jaga kelembabannya. Dalam 30-40 hari, kompos organik yang kaya nutrisi siap menyuburkan tanamanmu.</p>',
            ],
            [
                'judul' => 'Mengenal Sampah B3 dan Bahayanya Jika Sembarangan Dibuang',
                'kategori' => 'b3',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Apa itu Sampah B3?</h2><p>Bahan Berbahaya dan Beracun (B3) meliputi baterai bekas, lampu neon, kaleng aerosol, dan sisa obat-obatan. Membuangnya sembarangan ke tanah dapat mencemari air tanah dan membahayakan kesehatan warga sekitar. Kumpulkan sampah B3 dalam wadah tertutup dan serahkan pada fasilitas pengolahan limbah khusus.</p>',
            ],
            [
                'judul' => '5 Tips Jitu Mengurangi Penggunaan Plastik Sekali Pakai',
                'kategori' => 'tips',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Stop Ketergantungan Plastik!</h2><ol><li>Selalu bawa kantong belanja kain saat ke supermarket.</li><li>Gunakan botol minum (tumbler) sendiri.</li><li>Tolak sedotan plastik saat membeli minuman.</li><li>Bawa wadah makan sendiri saat jajan di luar.</li><li>Beralih ke sikat gigi bambu atau produk ramah lingkungan lainnya.</li></ol>',
            ],
            [
                'judul' => 'Panduan Memilah Sampah Sesuai Warna Tempat Sampah',
                'kategori' => 'edukasi',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Warna Tempat Sampah dan Maknanya</h2><p>Pemerintah membedakan tempat sampah menjadi 5 warna: <strong>Hijau</strong> untuk sampah organik (daun, sisa makanan). <strong>Kuning</strong> untuk sampah anorganik (plastik, kaleng). <strong>Merah</strong> untuk sampah B3. <strong>Biru</strong> untuk sampah kertas. <strong>Abu-abu</strong> untuk sampah residu (puntung rokok, popok). Mari biasakan memilah!</p>',
            ],
            [
                'judul' => 'Bahaya! Mengapa Minyak Jelantah Tidak Boleh Dibuang ke Wastafel?',
                'kategori' => 'b3',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1589923188900-85dae523342b?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Ancaman Tersembunyi di Pipa Pembuangan</h2><p>Minyak goreng bekas (jelantah) yang dibuang ke wastafel akan membeku dan menyumbat pipa saluran air. Lebih buruk lagi, minyak yang terbawa ke sungai akan menutupi permukaan air, menghalangi masuknya sinar matahari dan oksigen, mematikan ekosistem air. Kumpulkan jelantah di jerigen dan berikan ke pengepul untuk diolah menjadi biodiesel.</p>',
            ],
            [
                'judul' => 'Ide Kreatif Mengubah Botol Plastik Menjadi Pot Tanaman',
                'kategori' => 'daur_ulang',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Kebun Vertikal dari Botol Bekas</h2><p>Punya banyak botol air mineral bekas? Potong bagian tengah atau atasnya, lubangi bagian bawah untuk drainase air, lalu hias dengan cat. Isi dengan tanah dan bibit tanaman hias atau sayuran. Gantung botol-botol tersebut di dinding halamanmu untuk menciptakan kebun vertikal (vertical garden) yang cantik dan murah!</p>',
            ],
            [
                'judul' => 'Manfaat Cangkang Telur sebagai Pupuk Alami Tanaman Hias',
                'kategori' => 'kompos',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Kalsium Alami untuk Tanamanmu</h2><p>Jangan buang cangkang telur bekas sarapan! Cangkang telur sangat kaya akan kalsium yang dibutuhkan oleh dinding sel tanaman agar tumbuh kuat. Cara pakainya mudah: cuci bersih cangkang, keringkan di bawah sinar matahari, lalu tumbuk halus. Taburkan bubuk cangkang telur ke sekitar pangkal tanaman. Tanaman tomat dan mawar sangat menyukainya!</p>',
            ],
            [
                'judul' => 'Cara Tepat Mengelola Sampah Elektronik (E-Waste) yang Rusak',
                'kategori' => 'b3',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Jangan Buang HP Bekas ke Tempat Sampah Biasa!</h2><p>Kabel rusak, HP usang, kipas angin mati, hingga TV tabung tua tergolong sampah elektronik (E-Waste). Sampah ini mengandung logam berat seperti merkuri dan timbal. Jangan dibuang bersama sampah rumah tangga! Cari titik kumpul (*drop box*) E-Waste terdekat di kotamu atau donasikan ke lembaga daur ulang elektronik resmi.</p>',
            ],
            [
                'judul' => 'Gaya Hidup Minimalis: Langkah Awal Menyelamatkan Bumi',
                'kategori' => 'tips',
                'gambar_thumbnail' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=800&auto=format&fit=crop',
                'konten_html' => '<h2>Membeli Sesuai Kebutuhan, Bukan Keinginan</h2><p>Gaya hidup minimalis bukan sekadar tren estetik, tapi juga solusi konkret masalah sampah. Dengan hanya membeli barang yang benar-benar kita butuhkan, kita memutus rantai produksi berlebih dan penumpukan barang usang di TPA. Mulailah dengan menahan diri saat harbolnas, dan rawatlah barang yang ada agar awet lebih lama.</p>',
            ],
        ];

        $count = 0;
        foreach ($artikels as $data) {
            $data['penulis_admin_id'] = $admin->id;
            ArtikelEdukasi::create($data);
            $count++;
        }

        $this->command->info($count . ' artikel edukasi tambahan berhasil disisipkan!');
    }
}
