<?php

use Illuminate\Database\Seeder;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('matches')->insert([
            'team_1' => 25,
            'team_2' => 26,
            'emplacement'=> "Parc_des_princes",
            'beginning'=> date("2030-05-13 10:00:00"),
            'start'=>1,
            'cote_team_1'=>2.30,
            'cote_team_2'=>1.05,
            'cote_match_n'=>3.00,
        ]);
        DB::table('matches')->insert([
            'team_1' => 26,
            'team_2' => 27,
            'emplacement'=> "Stade_de_france",
            'beginning'=> date("2030-05-15 08:00:00"),
            'start'=>0,
            'cote_team_1'=>1.07,
            'cote_team_2'=>2.70,
            'cote_match_n'=>8.00,
        ]);
        DB::table('matches')->insert([
            'team_1' => 25,
            'team_2' => 27,
            'emplacement'=> "Orange_Vélodrome",
            'beginning'=> date("2030-05-17 05:00:00"),
            'start'=>0,
            'cote_team_1'=>1.20,
            'cote_team_2'=>3.50,
            'cote_match_n'=>2.00,
        ]);
        
    }
}
