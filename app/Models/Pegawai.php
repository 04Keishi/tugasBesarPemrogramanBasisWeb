<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'nama_pegawai',
        'jabatan',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'id_pegawai', 'id_pegawai');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_pegawai', 'id_pegawai');
    }
}
