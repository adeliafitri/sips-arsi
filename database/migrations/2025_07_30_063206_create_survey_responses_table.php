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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_form_id')->constrained('survey_forms')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa');
            $table->foreignId('matakuliah_kelasid')->nullable()->constrained('matakuliah_kelas');
            $table->foreignId('dosen_id')->nullable()->constrained('dosen');
            $table->string('nama_laboran')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
