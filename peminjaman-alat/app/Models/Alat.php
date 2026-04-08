<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';
    protected $fillable = ['nama_alat', 'kategori_id', 'kondisi', 'status', 'jumlah'];

    public function kategori()   { return $this->belongsTo(Kategori::class); }
    public function peminjaman() { return $this->hasMany(Peminjaman::class); }
}
