<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_rewards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            //$table->bigInteger( 'period_id' )->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity_rule')->unsigned();
            $table->integer('prod_point_val')->unsigned();
            //$table->timestamp( 'starts_at' )->nullable();
            //$table->timestamp( 'expires_at' )->nullable();
            //$table->enum('status',['ACTIVE','EXPIRED']);//jika ada perubahan nilai point atau quantity product
            $table->timestamps();

            //$table->foreign('client_id')->references('id')->on('b2b_client');
            //$table->foreign('period_id')->references('id')->on('target_periods');
            //$table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rewards');
    }
}
