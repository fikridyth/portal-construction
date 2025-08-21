<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPicToProyeks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->foreignId('user_pm')->nullable()->constrained('users');
            $table->foreignId('user_spv')->nullable()->constrained('users');
            $table->foreignId('user_purchasing')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropForeign(['user_pm']);
            $table->dropColumn('user_pm');

            $table->dropForeign(['user_spv']);
            $table->dropColumn('user_spv');

            $table->dropForeign(['user_purchasing']);
            $table->dropColumn('user_purchasing');
        });
    }
}
