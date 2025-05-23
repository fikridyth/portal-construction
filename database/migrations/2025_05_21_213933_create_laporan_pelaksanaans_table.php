<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPelaksanaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_pelaksanaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->bigInteger('bulan_ke');
            $table->date('dari');
            $table->date('sampai');
            $table->boolean('keadaan_tenaga')->default(false);
            $table->boolean('keadaan_bahan')->default(false);
            $table->boolean('keadaan_keuangan')->default(false);
            $table->decimal('realisasi', 16, 2)->nullable();
            $table->decimal('rencana', 16, 2)->nullable();
            $table->decimal('deviasi', 16, 2)->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('laporan_pelaksanaans');
    }
}
