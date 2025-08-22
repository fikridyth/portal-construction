<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_biayas', function (Blueprint $table) {
            $table->id();
            $table->string('account')->nullable();
            $table->string('name')->nullable();
            $table->string('currency')->nullable();
            $table->json('data')->nullable();
            $table->decimal('starting_balance', 16, 2)->nullable();
            $table->decimal('credit', 16, 2)->nullable();
            $table->decimal('debet', 16, 2)->nullable();
            $table->decimal('ending_balance', 16, 2)->nullable();
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
        Schema::dropIfExists('rekapitulasi_biayas');
    }
}
