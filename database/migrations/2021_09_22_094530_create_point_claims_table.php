<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_claims', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('custpoint_id')->unsigned();
            $table->integer('reward_id')->unsigned();
            $table->integer('type');
            $table->float('override_points')->nullable();
            $table->timestamps();

            //$table->foreign('customer_id')->references('id')->on('customers');
            //$table->foreign('reward_id')->references('id')->on('point_rewards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_claims');
    }
}
