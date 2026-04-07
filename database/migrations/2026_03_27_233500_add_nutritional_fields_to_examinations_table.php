<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->string('status_stunting')->nullable()->after('is_kek');
            $table->string('asupan_gizi')->nullable()->after('status_stunting');
            $table->string('imunisasi_gizi')->nullable()->after('asupan_gizi');
        });
    }

    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['status_stunting', 'asupan_gizi', 'imunisasi_gizi']);
        });
    }
};
