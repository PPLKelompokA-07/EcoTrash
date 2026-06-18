<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil petugas.
     */
    public function index(): View
    {
        $petugas = Auth::user()->load('petugasKomplek');
        return view('petugas.profil', compact('petugas'));
    }

    /**
     * Unggah/ganti foto profil petugas.
     */
    public function uploadFoto(Request $request): JsonResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'max:2048']
        ]);

        $petugas = Auth::user();

        $disk = config('filesystems.default') === 'local' ? 'public' : config('filesystems.default');

        // Hapus foto lama jika ada
        if ($petugas->foto_profil && Storage::disk($disk)->exists($petugas->foto_profil)) {
            Storage::disk($disk)->delete($petugas->foto_profil);
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('foto_profil', $disk);
        
        $petugas->update([
            'foto_profil' => $path
        ]);

        return response()->json([
            'url' => Storage::disk($disk)->url($path)
        ]);
    }

    /**
     * Lapor petugas berhalangan/sakit.
     */
    public function berhalangan(Request $request): JsonResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'min:5']
        ]);

        Auth::user()->update([
            'status_kehadiran' => 'berhalangan',
            'alasan_berhalangan' => $request->alasan,
        ]);

        return response()->json([
            'message' => 'Status kehadiran berhasil diperbarui menjadi berhalangan.'
        ]);
    }

    /**
     * Aktifkan kembali kehadiran petugas.
     */
    public function aktif(): JsonResponse
    {
        Auth::user()->update([
            'status_kehadiran' => 'aktif',
            'alasan_berhalangan' => null,
        ]);

        return response()->json([
            'message' => 'Status kehadiran berhasil diaktifkan kembali.'
        ]);
    }
}
