<?php

namespace Database\Seeders;

use App\Models\DetailPo;
use App\Models\Pegawai;
use App\Models\Product;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil referensi master yang sudah di-seed (ID auto-increment).
        $vendor   = Vendor::where('nama_supplier', 'PT. Garda Integra Solusindo')->first();
        $pegawai  = Pegawai::where('nama_pegawai', 'Winardo Mardanus')->first();
        $project  = Project::where('nama_project', 'like', 'Pengadaan Perbaikan Spare part%')->first();
        $produkA  = Product::where('deskripsi', 'Fire Control Module for Bell & Lamp ( FCM-1-CH )')->first();
        $produkB  = Product::where('deskripsi', 'Smoke Detector Addressable Notifier ( FSP-951-CH )')
                        ->where('nama_vendor', 'PT. Notifier Indonesia')->first();

        // ====== PURCHASE ORDER + INVOICE (tergabung) ======
        // Nomor PO & Invoice di-generate otomatis oleh model.
        $po = PurchaseOrder::create([
            'po_no'           => PurchaseOrder::generatePoNo(),
            'no_so'           => $project?->no_so,
            'id_vendor'       => $vendor?->id_vendor,
            'id_pegawai'      => $pegawai?->id_pegawai,
            'npwp'            => '70.720.171.1-036.000',
            'qty'             => 105,
            'payment'         => 'DP 30%, Pelunasan 70% CBD',
            'tanggal'         => '2024-01-15',
            'terbilang'       => '-',
            'grand_total'     => 0,
            // Field invoice (digabung ke PO)
            'no_invoice'      => PurchaseOrder::generateInvoiceNo(),
            'tanggal_invoice' => '2024-01-20',
            'alamat_invoice'  => 'Jl. Sungai No.44, Pangkalan Jati Baru, Kec. Cinere, Kota Depok, Jawa Barat 16513',
            'tax_code'        => '-',
            'total_invoice'   => 0,
            'no_telp'         => '(021) 7515957/58',
            'terms'           => '100%, 45 Days',
            'bast'            => '-',
            'spk_no'          => '-',
            'rekening'        => 'PT GARDA INTEGRA SOLUSINDO',
        ]);

        // ====== DETAIL PO (relasi ke PO via id_po) ======
        DetailPo::insert([
            [
                'id_po'          => $po->id_po,
                'id_product'     => $produkA?->id_product,
                'qty'            => 5,
                'diskon'         => 0,
                'subtotal_unit'  => 979725.00,
                'subtotal_final' => 4898625.00,
                'ppn_11'         => 0,
            ],
            [
                'id_po'          => $po->id_po,
                'id_product'     => $produkB?->id_product,
                'qty'            => 100,
                'diskon'         => 0,
                'subtotal_unit'  => 997760.00,
                'subtotal_final' => 99776000.00,
                'ppn_11'         => 0,
            ],
        ]);

        // Sinkronkan grand total + total invoice + terbilang dari item.
        $po->refresh()->syncGrandTotal();
    }
}
