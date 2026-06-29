<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'id_vendor';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'pic',
        'nama_supplier',
        'alamat',
        'nohp_pic',
        'no_telp',
        'fax',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'id_vendor', 'id_vendor');
    }
}
