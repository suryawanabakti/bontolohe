<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posyandu_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kader_id')->constrained('users')->onDelete('cascade');
            $table->integer('tahun');
            $table->integer('bulan')->nullable(); // Optional: monthly or annual target
            $table->integer('sasaran_bumil')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posyandu_targets');
    }
};
