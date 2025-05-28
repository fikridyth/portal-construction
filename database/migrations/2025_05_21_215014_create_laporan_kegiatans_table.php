<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->bigInteger('bulan_ke');
            $table->date('dari');
            $table->date('sampai');
            $table->json('list_pekerjaan')->nullable();
            $table->decimal('realisasi', 16, 2)->nullable();
            $table->decimal('rencana', 16, 2)->nullable();
            $table->decimal('kemajuan', 16, 2)->nullable();
            $table->string('situasi_pekerjaan')->nullable();
            $table->string('permasalahan')->nullable();
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
        Schema::dropIfExists('laporan_kegiatans');
    }
}
