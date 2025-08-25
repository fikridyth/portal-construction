<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSupplierToPreorders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preorders', function (Blueprint $table) {
            $table->foreignId('id_supplier')->nullable()->constrained('suppliers');
            $table->foreignId('id_tipe_pembayaran')->nullable()->constrained('tipe_pembayarans');
            $table->foreignId('id_manager')->nullable()->constrained('users');
            $table->foreignId('id_finance')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preorders', function (Blueprint $table) {
            $table->dropForeign(['id_supplier']);
            $table->dropColumn('id_supplier');
            
            $table->dropForeign(['id_tipe_pembayaran']);
            $table->dropColumn('id_tipe_pembayaran');

            $table->dropForeign(['id_manager']);
            $table->dropColumn('id_manager');

            $table->dropForeign(['id_finance']);
            $table->dropColumn('id_finance');
        });
    }
}
