<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->default(null)->nullable();
            $table->text('terms_of_use')->default(null)->nullable();
            $table->text('privacy_policy')->default(null)->nullable();
            
            $table->integer('location_id')->unsigned()->default(null)->nullable();
            $table->foreign('location_id')->references('id')->on('locations')
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
        Schema::dropIfExists('company_profiles');
    }
}
