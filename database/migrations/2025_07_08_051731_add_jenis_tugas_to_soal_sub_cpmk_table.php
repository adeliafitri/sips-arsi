<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('soal_sub_cpmk', function (Blueprint $table) {
            $table->string('jenis_tugas')->nullable()->after('soal_id');
        });
    }

    public function down()
    {
        Schema::table('soal_sub_cpmk', function (Blueprint $table) {
            $table->dropColumn('jenis_tugas');
        });
    }
};
