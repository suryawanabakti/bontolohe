<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->integer('tablet_fe')->default(0)->after('djj');
            $table->boolean('is_kek')->default(false)->after('tablet_fe');
        });
    }

    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['tablet_fe', 'is_kek']);
        });
    }
};
