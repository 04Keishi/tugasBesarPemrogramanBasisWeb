<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    /** Nilai default vendor untuk produk yang diproduksi sendiri. */
    public const VENDOR_SENDIRI = 'PT Garda Integra Solusindo';

    protected $fillable = [
        'deskripsi',
        'harga',
        'nama_vendor',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function detailPos()
    {
        return $this->hasMany(DetailPo::class, 'id_product', 'id_product');
    }
}
