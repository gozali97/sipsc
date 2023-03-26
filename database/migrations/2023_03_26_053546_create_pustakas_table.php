<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePustakasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pustakas', function (Blueprint $table) {
            $table->increments('id_pustaka');
            $table->string('Judul');
            $table->integer('id_kategori');
            $table->integer('id_pengarang');
            $table->integer('id_penerbit');
            $table->integer('jumlah');
            $table->string('tahun_terbit', 5);
            $table->string('isbn')->nullable();
            $table->string('gambar')->nullable();
            $table->string('status', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pustakas');
    }
}
