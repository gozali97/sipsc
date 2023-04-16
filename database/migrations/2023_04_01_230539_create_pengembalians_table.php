<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->string('no_kembali')->primary();
            $table->string('no_pinjam', 8);
            $table->integer('id_user');
            $table->dateTime('tgl_kembali');
            $table->integer('nominal_denda');
            $table->integer('jml_terlambat');
            $table->integer('kd_kondisi');
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
        Schema::dropIfExists('pengembalians');
    }
}