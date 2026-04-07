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
        Schema::table('patients', function (Blueprint $table) {
            $table->boolean('has_kms')->default(false)->after('kategori');
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->boolean('naik_berat_badan')->nullable()->after('berat_badan');
            $table->boolean('bgm')->default(false)->after('naik_berat_badan');
            $table->boolean('vitamin_a')->default(false)->after('bgm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('has_kms');
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['naik_berat_badan', 'bgm', 'vitamin_a']);
        });
    }
};
