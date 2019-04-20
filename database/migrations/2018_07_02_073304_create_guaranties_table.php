<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuarantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guaranties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->enum('type', ['KTP', 'KARTU KELUARGA', 'SIM', 'PASSPORT']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->integer('file_id')->unsigned()->default(null)->nullable();
            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('transaction_id')->unsigned()->default(null)->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')
                ->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('guaranties');
    }
}
