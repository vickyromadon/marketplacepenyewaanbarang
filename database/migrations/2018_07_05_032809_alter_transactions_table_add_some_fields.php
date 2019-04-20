<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionsTableAddSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('price');
            $table->enum('time_periode', ['Day', 'Week', 'Month', 'Year'])->default('Day');
            $table->string('total_periode');
            $table->string('deposite')->default('0');
            $table->string('grand_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('time_periode');
            $table->dropColumn('total_periode');
            $table->dropColumn('deposite');
            $table->dropColumn('grand_total');
        });
    }
}
