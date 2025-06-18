<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKomparasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_komparasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_preorder')->references('id')->on('preorders');
            $table->json('list_pesanan')->nullable();
            $table->date('dari');
            $table->date('sampai');
            $table->decimal('total_previous', 16, 2)->nullable();
            $table->decimal('total_progress', 16, 2)->nullable();
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
        Schema::dropIfExists('laporan_komparasis');
    }
}
