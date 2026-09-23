<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penugasans', function (Blueprint $table) {
            $table->text('alasan_penggantian')
                ->nullable()
                ->after('petugas_id');
        });
    }

    public function down(): void
    {
        Schema::table('penugasans', function (Blueprint $table) {
            $table->dropColumn('alasan_penggantian');
        });
    }
};