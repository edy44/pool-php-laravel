<?php

use Illuminate\Database\Seeder;

class BetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bets')->insert([
            'user_id' =>"2",
            'match_id' =>"2",
            'cote_bets' =>"2.03",
            'mise'=>"60",
            'win_bets'=>false,
            'gain'=>0,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('bets')->insert([
            'user_id' =>"3",
            'match_id' =>"2",
            'cote_bets' =>"7.03",
            'mise'=>"30",
            'win_bets'=>true,
            'gain'=>210.90,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('bets')->insert([
            'user_id' =>"4",
            'match_id' =>"2",
            'cote_bets' =>"1.03",
            'mise'=>"5",
            'win_bets'=>true,
            'gain'=>210.90,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);DB::table('bets')->insert([
            'user_id' =>"12",
            'match_id' =>"2",
            'cote_bets' =>"2.00",
            'mise'=>"60",
            'win_bets'=>true,
            'gain'=>120.00,
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
    }
}
