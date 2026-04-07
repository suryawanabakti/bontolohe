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
            $table->foreignId('kader_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->foreignId('kader_id')->nullable()->after('patient_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kader_id');
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kader_id');
        });
    }
};
