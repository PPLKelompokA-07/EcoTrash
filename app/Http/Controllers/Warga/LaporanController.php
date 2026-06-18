<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreLaporanRequest;
use App\Models\LaporanSampahLiar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan form pembuatan laporan sampah liar.
     * Kirim koordinat default dari komplek utama warga agar peta terpusat di area yang tepat.
     */
    public function create()
    {
        $user = Auth::user();
        $alamatUtama = $user->alamatUtama()->with('komplek')->first();

        // Default koordinat: komplek warga (jika ada) atau Jakarta Pusat sebagai fallback
        $defaultLat = $alamatUtama?->komplek?->lat ?? -6.200000;
        $defaultLng = $alamatUtama?->komplek?->lng ?? 106.816666;

        return view('warga.lapor.create', compact('defaultLat', 'defaultLng'));
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(StoreLaporanRequest $request)
    {
        $disk = config('filesystems.default') === 'local' ? 'public' : config('filesystems.default');

        // Upload foto ke storage
        $fotoPath = $request->file('foto')->store('laporan_warga', $disk);

        // Insert ke database
        $laporan = LaporanSampahLiar::create([
            'warga_id'            => Auth::id(),
            'lat'                 => $request->lat,
            'lng'                 => $request->lng,
            'alamat_lokasi'       => $request->alamat_lokasi,
            'deskripsi'           => $request->deskripsi,
            'foto_laporan_warga'  => $fotoPath,
            'status'              => 'menunggu',
        ]);

        // Redirect ke halaman berhasil dengan data laporan via session flash
        return redirect()->route('warga.lapor.berhasil')->with('laporan', $laporan);
    }

    /**
     * Tampilkan halaman berhasil setelah laporan terkirim.
     */
    public function berhasil()
    {
        return view('warga.lapor.berhasil');
    }
}
