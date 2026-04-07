<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_pemeriksaan');
            
            // Balita
            $table->float('berat_badan')->nullable();      // kg
            $table->float('tinggi_badan')->nullable();     // cm
            $table->float('lingkar_kepala')->nullable();   // cm
            $table->float('lila')->nullable();             // cm

            // Lansia / umum
            $table->string('tekanan_darah')->nullable();   // contoh: 120/80
            $table->float('suhu')->nullable();             // °C

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
