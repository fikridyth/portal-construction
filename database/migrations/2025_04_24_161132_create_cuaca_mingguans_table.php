<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuacaMingguansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuaca_mingguans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->foreignId('id_laporan_mingguan')->references('id')->on('laporan_mingguans');
            $table->bigInteger('minggu_ke');
            $table->json('list_cuaca')->nullable();
            $table->date('dari');
            $table->date('sampai');
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
        Schema::dropIfExists('cuaca_mingguans');
    }
}
