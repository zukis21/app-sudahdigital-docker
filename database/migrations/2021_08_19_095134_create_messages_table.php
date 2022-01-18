<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->string('m_tittle');
            $table->string('s_tittle');
            $table->string('c_tittle');
            $table->string('o_tittle');
            $table->timestamps();

            //$table->foreign('client_id')->references('id')->on('b2b_client');
        });

        /*Schema::table('messages', function($table) {
            $table->foreign('client_id')->references('id')->on('b2b_client');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
