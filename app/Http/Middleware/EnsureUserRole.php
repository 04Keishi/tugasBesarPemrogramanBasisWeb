<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Kontrol akses berbasis role.
 *
 * Aturan:
 *  - direktur : akses penuh (CRUD) ke semua modul.
 *  - pegawai (staff) :
 *      * Modul TRANSAKSI (purchase_order, detail_po) : CRUD penuh.
 *      * Modul MASTER Customer/Project/Vendor/Product : boleh Create, Read,
 *        Update — TIDAK boleh Delete.
 *      * Modul MASTER Pegawai : hanya boleh dilihat (read-only).
 *
 * Scope yang didukung (dipasang pada route yang mengubah data):
 *  - role:master         -> tulis master khusus direktur (mis. modul Pegawai).
 *  - role:master_write   -> Create/Update master untuk direktur & pegawai.
 *  - role:master_delete  -> Delete master khusus direktur.
 *  - role:transaksi      -> tulis modul transaksi untuk direktur & pegawai.
 */
class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $scope = 'master'): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Direktur bebas pada semua scope.
        if ($user->isDirektur()) {
            return $next($request);
        }

        // Pegawai (staff): boleh menulis pada transaksi & boleh Create/Update master.
        if ($user->isPegawai()) {
            if ($scope === 'transaksi' || $scope === 'master_write') {
                return $next($request);
            }

            // Scope 'master' (khusus direktur, mis. modul Pegawai) &
            // 'master_delete' (hapus master) ditolak untuk pegawai.
            return redirect()
                ->route('dashboard')
                ->with('flash_error', 'Anda tidak memiliki hak akses untuk tindakan ini.');
        }

        abort(403);
    }
}
