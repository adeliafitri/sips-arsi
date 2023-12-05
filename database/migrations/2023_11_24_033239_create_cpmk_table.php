<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpmkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('cpmk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matakuliah_id')->constrained('mata_kuliah');
            $table->foreignId('cpl_id')->constrained('cpl');
            $table->string('kode_cpmk');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpmk');
    }
}
