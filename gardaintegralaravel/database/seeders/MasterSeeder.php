<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Pegawai;
use App\Models\Product;
use App\Models\Project;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // ====== PEGAWAI (ID auto-increment) ======
        Pegawai::insert([
            ['nama_pegawai' => 'Winardo Mardanus', 'jabatan' => 'Direktur'],
            ['nama_pegawai' => 'Andi Pratama', 'jabatan' => 'Staff Finance'],
            ['nama_pegawai' => 'Budi Santoso', 'jabatan' => 'Project Manager'],
        ]);

        // ====== CUSTOMER (ID auto-increment) ======
        $cust1 = Customer::create([
            'nama_rek' => 'PT Garda Integra Solusindo',
            'no_rek'   => '1234567890',
            'alamat'   => 'Jl. Sungai No.44, Pangkalan Jati Baru, Kec. Cinere, Kota Depok, Jawa Barat 16513',
        ]);
        $cust2 = Customer::create([
            'nama_rek' => 'PT Mitra Sejahtera',
            'no_rek'   => '9876543210',
            'alamat'   => 'Jl. Raya Jakarta No.10, Jakarta Selatan',
        ]);

        // ====== PROJECT (No. SO auto-increment, relasi ke customer) ======
        Project::create(['id_customer' => $cust1->id_customer, 'nama_project' => 'Jasa Pemeliharaan dan Perbaikan Fire Alarm System (untuk 4 kali kunjungan)']);
        Project::create(['id_customer' => $cust1->id_customer, 'nama_project' => 'Pengadaan Perbaikan Sparepart Alarm Kebakaran']);
        Project::create(['id_customer' => $cust2->id_customer, 'nama_project' => 'Pengadaan Perbaikan Spare part Alarm Kebakaran PM']);

        // ====== VENDOR (ID auto-increment) ======
        Vendor::create([
            'pic'           => 'Winardo Mardanus',
            'nama_supplier' => 'PT. Garda Integra Solusindo',
            'alamat'        => 'Ruko Daan Mogot Baru KJD33, Jl. Raya Tampak Siring, Kalideres, Kota ADM. Jakarta Barat, DKI Jakarta, 11840',
            'nohp_pic'      => '081234567890',
            'no_telp'       => '(021) 7515957/58',
            'fax'           => '(021) 7507714',
        ]);
        Vendor::create([
            'pic'           => 'Rudi Hartono',
            'nama_supplier' => 'PT. Notifier Indonesia',
            'alamat'        => 'Jl. Industri Raya No.5, Tangerang, Banten',
            'nohp_pic'      => '081298765432',
            'no_telp'       => '(021) 5566778',
            'fax'           => '(021) 5566779',
        ]);

        // ====== PRODUCT (ID auto-increment; dengan harga satuan) ======
        // Produk dari vendor luar memakai nama vendor; produk produksi sendiri
        // otomatis memakai "PT Garda Integra Solusindo".
        Product::insert([
            ['deskripsi' => 'Fire Control Module for Bell & Lamp ( FCM-1-CH )', 'harga' => 979725.00, 'nama_vendor' => 'PT. Notifier Indonesia'],
            ['deskripsi' => 'Smoke Detector Addressable Notifier ( FSP-951-CH )', 'harga' => 997760.00, 'nama_vendor' => 'PT. Notifier Indonesia'],
            // Produk dengan deskripsi sama tetapi vendor berbeda = item baru.
            ['deskripsi' => 'Smoke Detector Addressable Notifier ( FSP-951-CH )', 'harga' => 950000.00, 'nama_vendor' => Product::VENDOR_SENDIRI],
            ['deskripsi' => 'Control Modul FCM', 'harga' => 850000.00, 'nama_vendor' => Product::VENDOR_SENDIRI],
            ['deskripsi' => 'Jasa Pemeliharaan dan Perbaikan Fire Alarm System', 'harga' => 15000000.00, 'nama_vendor' => Product::VENDOR_SENDIRI],
        ]);
    }
}
