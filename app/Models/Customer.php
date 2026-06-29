<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_customer',
        'nama_rek',
        'no_rek',
        'alamat',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'id_customer', 'id_customer');
    }
}
