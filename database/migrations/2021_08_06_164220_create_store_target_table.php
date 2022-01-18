<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_target', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('customer_id');
            $table->double('target_values',14,2)->default(0)->unsigned();
            $table->double('target_achievement',14,2)->default(0)->unsigned();
            $table->date('period');
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
        Schema::dropIfExists('store_target');
    }
}
