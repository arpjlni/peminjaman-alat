<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id')->constrained('pengembalian')->onDelete('cascade');
            $table->integer('hari_terlambat')->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
