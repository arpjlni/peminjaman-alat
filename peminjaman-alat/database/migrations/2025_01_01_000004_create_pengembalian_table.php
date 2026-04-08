<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->date('tgl_pengembalian');
            $table->string('kondisi_alat')->default('baik');
            $table->decimal('denda', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
