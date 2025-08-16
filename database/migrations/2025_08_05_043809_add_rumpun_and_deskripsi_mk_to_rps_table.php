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
        Schema::table('rps', function (Blueprint $table) {
            $table->string('rumpun_mk')->nullable()->after('pustaka');
            $table->text('deskripsi_mk')->nullable()->after('rumpun_mk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rps', function (Blueprint $table) {
            $table->dropColumn(['rumpun_mk', 'deskripsi_mk']);
        });
    }
};
