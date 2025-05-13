<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    public $timestamps = false;

    protected $fillable = ['nama_kurir', 'no_hp', 'jenis_kurir', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'id_pengiriman');
    }
    
}
