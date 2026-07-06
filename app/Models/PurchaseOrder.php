<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $primaryKey = 'id_po';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    // po_no & no_invoice di-generate otomatis, bukan diinput user.
    protected $fillable = [
        'po_no',
        'no_so',
        'id_vendor',
        'id_pegawai',
        'npwp',
        'qty',
        'payment',
        'tanggal',
        'terbilang',
        'grand_total',
        // Field invoice (digabung ke PO)
        'no_invoice',
        'tanggal_invoice',
        'alamat_invoice',
        'tax_code',
        'total_invoice',
        'no_telp',
        'terms',
        'bast',
        'spk_no',
        'rekening',
    ];

    protected $casts = [
        'tanggal'         => 'date',
        'tanggal_invoice' => 'date',
        'grand_total'     => 'decimal:2',
        'total_invoice'   => 'decimal:2',
        'qty'             => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'no_so', 'no_so');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function details()
    {
        return $this->hasMany(DetailPo::class, 'id_po', 'id_po');
    }

    /**
     * Generate nomor PO otomatis dengan format:
     *   {urut}/PO/GIS/{romawi-bulan}/{tahun}
     * Contoh: 001/PO/GIS/I/2024
     */
    public static function generatePoNo(): string
    {
        $now = now();
        $next = (int) static::max('id_po') + 1;
        $urut = str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        return $urut . '/PO/GIS/' . self::bulanRomawi((int) $now->format('n')) . '/' . $now->format('Y');
    }

    /**
     * Generate nomor invoice otomatis dengan format:
     *   {urut}/GIS-INV/{romawi-bulan}/{tahun}
     */
    public static function generateInvoiceNo(): string
    {
        $now = now();
        $next = (int) static::whereNotNull('no_invoice')->count() + 1;
        $urut = str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        return $urut . '/GIS-INV/' . self::bulanRomawi((int) $now->format('n')) . '/' . $now->format('Y');
    }

    private static function bulanRomawi(int $bulan): string
    {
        $romawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        return $romawi[$bulan] ?? 'I';
    }

    /**
     * Hitung ulang Grand Total dari item Detail PO:
     *   Grand Total = SUM(subtotal_final) + PPN 11%
     */
    public function syncGrandTotal(): void
    {
        $sumFinal = (float) $this->details()->sum('subtotal_final');
        $grand = $sumFinal + round($sumFinal * 0.11);

        $this->grand_total = $grand;
        $this->terbilang = \App\Support\Terbilang::rupiah($grand);

        // Total invoice mengikuti nilai dasar item (sebelum PPN) bila ada item.
        $this->total_invoice = $sumFinal > 0 ? $sumFinal : $this->total_invoice;

        $this->save();
    }
}
