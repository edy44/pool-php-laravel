<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('players')->default(0);
            $table->integer('win')->default(0);
            $table->integer('loose')->default(0);
            $table->integer('ranking')->default(0);
            $table->integer('team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stat_teams', function (Blueprint $table) {
            Schema::dropIfExists('stat_teams');
        });
    }
}
