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
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->string('tahun_akademik', 9)->nullable()->after('kendala_skripsi'); // Contoh: 2024/2025
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable()->after('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn(['tahun_akademik', 'semester']);
        });
    }
};
