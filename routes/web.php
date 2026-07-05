<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPoController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing & Auth
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Area terproteksi (harus login)
|--------------------------------------------------------------------------
| Seluruh identifier kini berupa integer auto-increment, sehingga aman
| dilewatkan sebagai path parameter biasa. Nomor PO / Invoice (yang
| mengandung '/') hanya untuk tampilan dan tidak dipakai sebagai key URL.
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* ===================== MASTER ===================== */
    $masterControllers = [
        'pegawai'  => PegawaiController::class,
        'customer' => CustomerController::class,
        'project'  => ProjectController::class,
        'vendor'   => VendorController::class,
        'product'  => ProductController::class,
    ];

    // Modul master yang boleh di-Create/Update oleh Pegawai (staff),
    // tetapi Delete tetap khusus Direktur. Modul 'pegawai' TIDAK termasuk:
    // seluruh perubahannya khusus Direktur (pegawai hanya read-only).
    $staffWritableMaster = ['customer', 'project', 'vendor', 'product'];

    foreach ($masterControllers as $name => $controller) {
        Route::get("master/{$name}", [$controller, 'index'])->name("{$name}.index");

        if (in_array($name, $staffWritableMaster, true)) {
            // Create & Update: Direktur + Pegawai.
            Route::middleware('role:master_write')->group(function () use ($name, $controller) {
                Route::get("master/{$name}/create", [$controller, 'create'])->name("{$name}.create");
                Route::post("master/{$name}", [$controller, 'store'])->name("{$name}.store");
                Route::get("master/{$name}/{id}/edit", [$controller, 'edit'])->name("{$name}.edit");
                Route::put("master/{$name}/{id}", [$controller, 'update'])->name("{$name}.update");
            });

            // Delete: khusus Direktur.
            Route::middleware('role:master_delete')->group(function () use ($name, $controller) {
                Route::delete("master/{$name}/{id}", [$controller, 'destroy'])->name("{$name}.destroy");
            });
        } else {
            // Modul master lain (mis. Pegawai): seluruh perubahan khusus Direktur.
            Route::middleware('role:master')->group(function () use ($name, $controller) {
                Route::get("master/{$name}/create", [$controller, 'create'])->name("{$name}.create");
                Route::post("master/{$name}", [$controller, 'store'])->name("{$name}.store");
                Route::get("master/{$name}/{id}/edit", [$controller, 'edit'])->name("{$name}.edit");
                Route::put("master/{$name}/{id}", [$controller, 'update'])->name("{$name}.update");
                Route::delete("master/{$name}/{id}", [$controller, 'destroy'])->name("{$name}.destroy");
            });
        }
    }

    /* ============= TRANSAKSI — Purchase Order (Invoice tergabung) ============= */
    Route::get('transaksi/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase_order.index');
    Route::middleware('role:transaksi')->group(function () {
        Route::get('transaksi/purchase-order/create', [PurchaseOrderController::class, 'create'])->name('purchase_order.create');
        Route::post('transaksi/purchase-order', [PurchaseOrderController::class, 'store'])->name('purchase_order.store');
        Route::get('transaksi/purchase-order/{id_po}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase_order.edit');
        Route::put('transaksi/purchase-order/{id_po}', [PurchaseOrderController::class, 'update'])->name('purchase_order.update');
        Route::delete('transaksi/purchase-order/{id_po}', [PurchaseOrderController::class, 'destroy'])->name('purchase_order.destroy');
    });

    /* ============= TRANSAKSI — Detail PO ============= */
    Route::get('transaksi/detail-po', [DetailPoController::class, 'index'])->name('detail_po.index');
    Route::middleware('role:transaksi')->group(function () {
        Route::get('transaksi/detail-po/create', [DetailPoController::class, 'create'])->name('detail_po.create');
        Route::post('transaksi/detail-po', [DetailPoController::class, 'store'])->name('detail_po.store');
        Route::get('transaksi/detail-po/{id_detail}/edit', [DetailPoController::class, 'edit'])->name('detail_po.edit');
        Route::put('transaksi/detail-po/{id_detail}', [DetailPoController::class, 'update'])->name('detail_po.update');
        Route::delete('transaksi/detail-po/{id_detail}', [DetailPoController::class, 'destroy'])->name('detail_po.destroy');
    });

    /* ===================== CETAK ===================== */
    Route::get('cetak/purchase-order', [CetakController::class, 'purchaseOrder'])->name('cetak.po');
    Route::get('cetak/invoice', [CetakController::class, 'invoice'])->name('cetak.invoice');
});
