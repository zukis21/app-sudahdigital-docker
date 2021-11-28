<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryQtyOnOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->integer('deliveryQty')->unsigned()->nullable();
            //$table->integer('remainingQty')->unsigned()->nullable();
            //$table->text( 'partialShipNotes' )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn('deliveryQty');
            //$table->dropColumn('remainingQty');
            //$table->dropColumn('partialShipNotes');
        });
    }
}
