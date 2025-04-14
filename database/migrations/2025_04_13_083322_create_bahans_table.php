<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->decimal('volume', 16, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_modal_material', 16, 2)->nullable();
            $table->decimal('harga_modal_upah', 16, 2)->nullable();
            $table->decimal('harga_jual', 16, 2)->nullable();
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
        Schema::dropIfExists('bahans');
    }
}
