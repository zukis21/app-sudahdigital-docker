<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_targets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('storeTargetId')->unsigned();
            $table->integer('productId')->unsigned();
            $table->double('nominalValues',11,2)->default(0)->unsigned();
            $table->integer('quantityValues')->default(0)->unsigned();
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
        Schema::dropIfExists('product_targets');
    }
}
