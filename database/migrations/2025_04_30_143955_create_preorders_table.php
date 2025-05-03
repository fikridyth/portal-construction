<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->references('id')->on('proyeks');
            $table->foreignId('id_laporan_mingguan')->references('id')->on('laporan_mingguans');
            $table->string('no_po');
            $table->bigInteger('minggu_ke');
            $table->json('list_pesanan')->nullable();
            $table->date('dari');
            $table->date('sampai');
            $table->decimal('total', 16, 2)->nullable();
            $table->decimal('bobot_total', 16, 2)->nullable();
            $table->bigInteger('status');
            $table->string('kode_bayar');
            $table->foreignId('approved_manager_by')->nullable()->constrained('users');
            $table->timestamp('approved_manager_at')->nullable();
            $table->foreignId('approved_owner_by')->nullable()->constrained('users');
            $table->timestamp('approved_owner_at')->nullable();
            $table->foreignId('approved_finance_by')->nullable()->constrained('users');
            $table->timestamp('approved_finance_at')->nullable();
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
        Schema::dropIfExists('preorders');
    }
}
