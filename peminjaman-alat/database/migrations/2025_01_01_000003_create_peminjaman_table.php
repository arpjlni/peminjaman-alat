<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali'); // rencana kembali
            $table->enum('status_peminjaman', ['menunggu', 'disetujui', 'ditolak', 'dikembalikan'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
