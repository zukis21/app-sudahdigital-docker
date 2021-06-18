<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB2bClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2b_client', function (Blueprint $table) {
            $table->id();
            $table->string('client_name')->unique();
            $table->string('client_image');
            $table->string('client_slug')->unique();
            $table->string('company_name');
            $table->string('email')->unique();
            $table->string('phone_whatsapp');
            $table->string('phone');
            $table->text('client_address');
            $table->text('fb_url')->nullable();
            $table->text('inst_url')->nullable();
            $table->text('ytb_url')->nullable();
            $table->text('twt_url')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE']);
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
        Schema::dropIfExists('b2b_client');
    }
}
