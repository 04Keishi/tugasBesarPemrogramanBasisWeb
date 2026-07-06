<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPo extends Model
{
    protected $table = 'detail_po';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_po',
        'id_product',
        'qty',
        'diskon',
        'subtotal_unit',
        'subtotal_final',
        'ppn_11',
    ];

    protected $casts = [
        'qty'            => 'integer',
        'diskon'         => 'decimal:2',
        'subtotal_unit'  => 'decimal:2',
        'subtotal_final' => 'decimal:2',
        'ppn_11'         => 'decimal:2',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'id_po', 'id_po');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
