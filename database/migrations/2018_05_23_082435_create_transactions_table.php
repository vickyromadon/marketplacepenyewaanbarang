<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name_of_sender')->nullable();
            $table->string('account_number_of_sender')->nullable();
            $table->string('bank_name_of_sender')->nullable();
            $table->date('transfer_date')->nullable();
            $table->enum('payment_method', ['rekber', 'cod'])->default(null);
            $table->enum('status', ['pending', 'approved', 'rejected', 'canceled', 'verified'])->default('pending');
            $table->text('note')->default(null)->nullable();

            $table->integer('file_id')->unsigned()->default(null)->nullable();
            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('bank_id')->unsigned()->default(null)->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('booking_id')->unsigned()->default(null)->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('transactions');
    }
}
