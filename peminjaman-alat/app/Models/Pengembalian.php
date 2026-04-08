<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $fillable = ['peminjaman_id', 'tgl_pengembalian', 'kondisi_alat', 'denda'];

    protected $casts = ['tgl_pengembalian' => 'date'];

    public function peminjaman() { return $this->belongsTo(Peminjaman::class); }
    public function denda()      { return $this->hasOne(Denda::class); }
}
