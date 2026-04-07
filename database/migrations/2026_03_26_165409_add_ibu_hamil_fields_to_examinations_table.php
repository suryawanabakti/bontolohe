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
        Schema::table('examinations', function (Blueprint $table) {
            // Ibu Hamil
            $table->float('tfu')->nullable()->after('suhu')->comment('Tinggi Fundus Uteri (cm)');
            $table->integer('djj')->nullable()->after('tfu')->comment('Detak Jantung Janin (bpm)');
            
            // Umum
            $table->text('catatan')->nullable()->after('djj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['tfu', 'djj', 'catatan']);
        });
    }
};
