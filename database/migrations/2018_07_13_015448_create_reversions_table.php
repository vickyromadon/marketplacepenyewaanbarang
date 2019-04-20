<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reversions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default(null)->nullable();
            $table->string('phone', 15)->default(null)->nullable();
            $table->text('address')->default(null)->nullable();
            $table->date('delivery_date')->default(null)->nullable();
            $table->date('arrive_date')->default(null)->nullable();
            $table->enum('status', ['empty', 'pending', 'delivered', 'arrived'])->default('empty');

            $table->integer('delivery_id')->unsigned()->default(null)->nullable();
            $table->foreign('delivery_id')->references('id')->on('deliveries')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('file_id')->unsigned()->default(null)->nullable();
            $table->foreign('file_id')->references('id')->on('files')
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
        Schema::dropIfExists('reversions');
    }
}
