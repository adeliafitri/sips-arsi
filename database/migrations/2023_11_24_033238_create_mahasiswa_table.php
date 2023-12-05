<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_auth')->constrained('auth');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->text('alamat')->nullable();
            $table->string('telp')->unique();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('mahasiswa');
    }
}
