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
        Schema::create('survey_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_response_id')->constrained('survey_responses')->onDelete('cascade');
            $table->enum('kategori', [
                'laboran',
                'staf_admin',
                'manajemen_prodi',
                'visi_misi',
                'roadmap_penelitian',
                'sarpras'
            ]);
            $table->text('isi_saran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_suggestions');
    }
};
