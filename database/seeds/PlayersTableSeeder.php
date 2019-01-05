<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('players')->insert([
            'name' => "Michel",
            'team_id' => 1,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('players')->insert([
            'name' => "Robert",
            'team_id' => 1,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('players')->insert([
            'name' => "Francesco",
            'team_id' => 3,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('players')->insert([
            'name' => "Mario",
            'team_id' => 3,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('players')->insert([
            'name' => "Ronaldo",
            'team_id' => 2,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
    }
}
