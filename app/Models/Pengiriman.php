<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = "pengiriman";
    protected $primaryKey = "id_pengiriman";
    public $timestamps = false;
    protected $fillable = ["tujuan", "tanggal", "armada", "muatan", "nomor_kendaraan"];

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }

}
