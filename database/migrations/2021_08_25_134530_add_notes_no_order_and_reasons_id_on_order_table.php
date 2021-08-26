<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesNoOrderAndReasonsIdOnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('reasons_id')->unsigned()->nullable();
            $table->text('notes_no_order')->nullable();

            $table->foreign('reasons_id')->references('id')->on('reasons_checkouts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('reasons_id');
            $table->dropColumn('notes_no_order');
        });
    }
}
