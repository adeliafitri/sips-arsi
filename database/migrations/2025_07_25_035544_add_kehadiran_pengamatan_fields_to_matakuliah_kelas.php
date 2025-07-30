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
        Schema::table('matakuliah_kelas', function (Blueprint $table) {
            $table->float('kehadiran_dosen', 5, 2)->nullable()->after('semester_id');
            $table->float('kehadiran_mahasiswa', 5, 2)->nullable()->after('kehadiran_dosen');
            $table->text('keterangan_kehadiran')->nullable()->after('kehadiran_mahasiswa');
            $table->text('pengamatan_kelas')->nullable()->after('keterangan_kehadiran');
            $table->text('kesimpulan')->nullable()->after('pengamatan_kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matakuliah_kelas', function (Blueprint $table) {
            $table->dropColumn([
                'kehadiran_dosen',
                'kehadiran_mahasiswa',
                'kesimpulan',
                'keterangan_kehadiran',
                'pengamatan_kelas',
            ]);
        });
    }
};
