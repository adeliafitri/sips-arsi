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
            $table->string('lampiran2_path')->nullable()->after('kesimpulan');
            $table->string('lampiran4_path')->nullable()->after('lampiran2_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matakuliah_kelas', function (Blueprint $table) {
            $table->dropColumn(['lampiran2_path', 'lampiran4_path']);
        });
    }
};
