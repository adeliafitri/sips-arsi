<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->string('nama_staf_administrasi')->nullable()->after('nama_laboran');
            $table->date('tanggal_sempro')->nullable()->after('nama_staf_administrasi');
            $table->date('tanggal_sidang')->nullable()->after('tanggal_sempro');
        });

        DB::statement("ALTER TABLE survey_responses ADD COLUMN kendala_skripsi SET('komunikasi','sarana prasarana','keuangan','motivasi','tidak ada kendala','lainnya') NULL AFTER tanggal_sidang");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn(['nama_staf_administrasi', 'tanggal_sempro', 'tanggal_sidang']);
        });

        DB::statement("ALTER TABLE survey_responses DROP COLUMN kendala_skripsi");
    }
};
