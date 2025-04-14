<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->foreignId('id_pekerjaan')->references('id')->on('pekerjaans');
            $table->string('nama');
            $table->decimal('volume', 16, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_modal_material', 16, 2)->nullable();
            $table->decimal('harga_modal_upah', 16, 2)->nullable();
            $table->decimal('harga_jual_satuan', 16, 2)->nullable();
            $table->decimal('harga_jual_total', 16, 2)->nullable();
            $table->boolean('is_bahan');
            $table->json('list_bahan')->nullable();
            $table->decimal('vol_pemakaian', 16, 2)->nullable();
            $table->decimal('harga_pemakaian', 16, 2)->nullable();
            $table->decimal('vol_sisa', 16, 2)->nullable();
            $table->decimal('harga_sisa', 16, 2)->nullable();
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
        Schema::dropIfExists('detail_pekerjaans');
    }
}
