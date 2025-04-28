<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->string('nama');
            $table->decimal('volume', 16, 2)->nullable();
            $table->decimal('harga', 16, 2)->nullable();
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
        Schema::dropIfExists('ccos');
    }
}
