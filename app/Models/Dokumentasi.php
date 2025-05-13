<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'dokumentasi';
    protected $primaryKey = 'id_dokumentasi';
    public $timestamps = false;

    protected $fillable = ['id_pengiriman', 'path'];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'id_Pengiriman');
    }
}
