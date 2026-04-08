<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create(['username' => 'admin',    'nama' => 'Administrator', 'email' => 'admin@app.com',    'password' => Hash::make('admin123'),    'role' => 'admin']);
        User::create(['username' => 'petugas',  'nama' => 'Petugas Satu',  'email' => 'petugas@app.com',  'password' => Hash::make('petugas123'),  'role' => 'petugas']);
        User::create(['username' => 'peminjam', 'nama' => 'Peminjam Satu', 'email' => 'peminjam@app.com', 'password' => Hash::make('    '), 'role' => 'peminjam']);

        // Kategori
        $elektronik = Kategori::create(['nama_kategori' => 'Elektronik']);
        $pertukangan = Kategori::create(['nama_kategori' => 'Pertukangan']);
        $ukur = Kategori::create(['nama_kategori' => 'Alat Ukur']);

        // Alat
        Alat::create(['nama_alat' => 'Laptop',       'kategori_id' => $elektronik->id,  'kondisi' => 'baik', 'status' => 'tersedia', 'jumlah' => 5]);
        Alat::create(['nama_alat' => 'Proyektor',    'kategori_id' => $elektronik->id,  'kondisi' => 'baik', 'status' => 'tersedia', 'jumlah' => 3]);
        Alat::create(['nama_alat' => 'Bor Listrik',  'kategori_id' => $pertukangan->id, 'kondisi' => 'baik', 'status' => 'tersedia', 'jumlah' => 2]);
        Alat::create(['nama_alat' => 'Multimeter',   'kategori_id' => $ukur->id,        'kondisi' => 'baik', 'status' => 'tersedia', 'jumlah' => 4]);
        Alat::create(['nama_alat' => 'Oscilloscope', 'kategori_id' => $ukur->id,        'kondisi' => 'baik', 'status' => 'tersedia', 'jumlah' => 2]);
    }
}
