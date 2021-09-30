<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndOverridePointsOnPointClaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_claims', function (Blueprint $table) {
            $table->integer('type');
            $table->float('override_points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_claims', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('override_points');
        });
    }
}
