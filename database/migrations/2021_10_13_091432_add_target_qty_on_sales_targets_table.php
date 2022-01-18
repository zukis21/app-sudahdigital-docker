<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetQtyOnSalesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_targets', function (Blueprint $table) {
            $table->integer('target_type')->unsigned()->default(0);
            $table->integer('target_quantity')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_targets', function (Blueprint $table) {
            $table->dropColumn('target_type');
            $table->dropColumn('target_quantity');
        });
    }
}
