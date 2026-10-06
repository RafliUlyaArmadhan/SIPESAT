<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('desas', function (Blueprint $table) {
            $table->string('kode_desa', 20)->nullable()->unique()->after('nama_desa');
        });
    }

    public function down(): void
    {
        Schema::table('desas', function (Blueprint $table) {
            $table->dropColumn('kode_desa');
        });
    }
};