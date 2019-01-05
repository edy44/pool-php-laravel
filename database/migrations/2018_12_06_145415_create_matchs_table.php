<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_1');
            $table->integer('team_2');
            $table->string('emplacement');
            $table->string('score')->nullable();
            $table->timestamp('beginning');
            $table->integer('start');
            $table->integer('winner')->nullable();
            $table->float('cote_team_1');
            $table->float('cote_team_2');
            $table->float('cote_match_n');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }

}
