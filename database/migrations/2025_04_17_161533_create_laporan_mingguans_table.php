<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanMingguansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_mingguans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->json('list_pekerjaan')->nullable();
            $table->bigInteger('minggu_ke');
            $table->decimal('bobot_minggu_lalu', 16, 2)->nullable();
            $table->decimal('bobot_minggu_ini', 16, 2)->nullable();
            $table->decimal('bobot_rencana', 16, 2)->nullable();
            $table->decimal('bobot_total', 16, 2)->nullable();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('laporan_mingguans');
    }
}
