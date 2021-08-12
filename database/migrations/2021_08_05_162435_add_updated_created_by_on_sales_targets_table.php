<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedCreatedByOnSalesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_targets', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
