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
            'foto' => ['required', 'image', 'max:10240']
        ]);

        $petugas = Auth::user();

        // Hapus foto lama dari DatabaseFile jika ada
        if ($petugas->foto_profil && str_starts_with($petugas->foto_profil, 'db/')) {
            $oldFilename = str_replace('db/', '', $petugas->foto_profil);
            \App\Models\DatabaseFile::where('filename', $oldFilename)->delete();
        }

        // Simpan foto baru
        $foto = $request->file('foto');
        $filename = uniqid('profil_petugas_') . '.jpg';

        $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $compressedImage = $imageManager->read($foto->getRealPath())
                                        ->scaleDown(width: 800)
                                        ->toJpeg(75);

        \App\Models\DatabaseFile::create([
            'filename' => $filename,
            'mime_type' => 'image/jpeg',
            'data' => $compressedImage->toString(),
        ]);

        $path = 'db/' . $filename;
        
        $petugas->update([
            'foto_profil' => $path
        ]);

        return response()->json([
            'url' => url('images/' . $path)
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

        $petugas = Auth::user();

        $petugas->update([
            'status_kehadiran' => 'berhalangan',
            'alasan_berhalangan' => $request->alasan,
            'berhalangan_until' => now()->endOfDay(),
        ]);

        // Auto-Unassign Pesanan Pengangkutan
        $activePesanan = \App\Models\PesananPengangkutan::where('petugas_id', $petugas->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan', 'gagal_pickup'])
            ->get();
        
        $countPesanan = $activePesanan->count();
        if ($countPesanan > 0) {
            \App\Models\PesananPengangkutan::whereIn('id', $activePesanan->pluck('id'))
                ->update([
                    'petugas_id' => null,
                    'status' => 'menunggu'
                ]);
        }


        // Beritahu Admin
        $admins = \App\Models\User::where('role', 'admin')->pluck('id')->toArray();
        if (!empty($admins)) {
            $pesanNotif = "Petugas {$petugas->nama} melaporkan berhalangan. Alasan: {$request->alasan}.";
            
            if ($countPesanan > 0) {
                $pesanNotif .= " Terdapat {$countPesanan} Pesanan yang status assign-nya telah dibatalkan dan dikembalikan ke antrean.";
            }

            \App\Services\NotificationService::sendToMany(
                $admins,
                'Petugas Berhalangan',
                $pesanNotif,
                'warning'
            );
        }

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
            'berhalangan_until' => null,
        ]);

        return response()->json([
            'message' => 'Status kehadiran berhasil diaktifkan kembali.'
        ]);
    }
}
