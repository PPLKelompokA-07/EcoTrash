<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPetugasStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'petugas') {
            if ($user->status_kehadiran === 'berhalangan' && $user->berhalangan_until) {
                if (now()->greaterThan($user->berhalangan_until)) {
                    $user->update([
                        'status_kehadiran' => 'aktif',
                        'alasan_berhalangan' => null,
                        'berhalangan_until' => null,
                    ]);
                }
            }
        }

        return $next($request);
    }
}
