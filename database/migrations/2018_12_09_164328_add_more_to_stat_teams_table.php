<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreToStatTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stat_teams', function (Blueprint $table) {
            $table->integer('nul')->default(0);
            $table->integer('matches')->default(0);
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
            $table->dropColumn('nul');
            $table->dropColumn('matches');
        });
    }
}
