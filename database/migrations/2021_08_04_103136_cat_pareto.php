<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatPareto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_pareto', function (Blueprint $table) {
            $table->id();
            $table->string('pareto_code');
            $table->string('name');
            $table->integer('client_id')->unsigned();
            $table->integer('position')->unsigned();
            $table->enum('status',['ACTIVE','INACTIVE']);
            $table->timestamps();
            
            //$table->foreign('client_id')->references('id')->on('b2b_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_pareto');
    }
}
