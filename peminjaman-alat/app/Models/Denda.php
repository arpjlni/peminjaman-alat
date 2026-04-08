<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';
    protected $fillable = ['pengembalian_id', 'hari_terlambat', 'total_denda'];

    public function pengembalian() { return $this->belongsTo(Pengembalian::class); }
}
