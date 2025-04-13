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
            $table->foreignId('id_proyek')->references('id')->on('users');
            $table->foreignId('id_pekerjaan')->references('id')->on('users');
            $table->string('nama')->unique();
            $table->decimal('volume', 5, 2)->default(0);
            $table->string('satuan')->nullable();
            $table->bigInteger('harga_modal_material')->default(0);
            $table->bigInteger('harga_modal_upah')->default(0);
            $table->bigInteger('harga_jual_satuan')->default(0);
            $table->bigInteger('harga_jual_total')->default(0);
            $table->boolean('is_bahan');
            $table->json('list_bahan')->nullable();
            $table->decimal('vol_pemakaian', 5, 2)->default(0);
            $table->bigInteger('harga_pemakaian')->default(0);
            $table->decimal('vol_sisa', 5, 2)->default(0);
            $table->bigInteger('harga_sisa')->default(0);
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
