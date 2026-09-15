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
        Schema::table('laporan_sampahs', function (Blueprint $table) {

            $table->string('kode_laporan')->unique()->after('id');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->after('kode_laporan');

            $table->foreignId('kategori_sampah_id')
                ->constrained('kategori_sampah')
                ->restrictOnDelete()
                ->after('user_id');

            $table->string('kecamatan')->after('kategori_sampah_id');

            $table->string('desa')->after('kecamatan');

            $table->string('judul_laporan')->after('desa');

            $table->text('deskripsi')->after('judul_laporan');

            $table->text('alamat_lengkap')->after('deskripsi');

            $table->decimal('latitude', 10, 7)->nullable()->after('alamat_lengkap');

            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');

            $table->json('foto_laporan')->nullable()->after('longitude');

            $table->string('status')
                ->default('menunggu_verifikasi')
                ->after('foto_laporan');

            $table->text('alasan_penolakan')->nullable()->after('status');

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('alasan_penolakan');

            $table->timestamp('verified_at')
                ->nullable()
                ->after('verified_by');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_sampahs', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['kategori_sampah_id']);
            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'kode_laporan',
                'user_id',
                'kategori_sampah_id',
                'kecamatan',
                'desa',
                'judul_laporan',
                'deskripsi',
                'alamat_lengkap',
                'latitude',
                'longitude',
                'foto_laporan',
                'status',
                'alasan_penolakan',
                'verified_by',
                'verified_at',
                'completed_at',
            ]);
        });
    }
};