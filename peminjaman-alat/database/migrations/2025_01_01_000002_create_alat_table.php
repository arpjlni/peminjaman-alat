<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('kondisi')->default('baik'); // baik, rusak, perbaikan
            $table->string('status')->default('tersedia'); // tersedia, dipinjam
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
