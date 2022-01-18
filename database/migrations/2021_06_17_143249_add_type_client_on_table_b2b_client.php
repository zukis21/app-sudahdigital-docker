<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeClientOnTableB2bClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('b2b_client', function (Blueprint $table) {
            $table->enum('type',['CLIENT','OWNER']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('b2b_client', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
