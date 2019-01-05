<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voidphp artisan db:seed --class=UsersTableSeeder
     */
    public function run()
    {

        DB::table('teams')->insert([
            'name' => "Sans Equipe",
            'flag' => "Sans Equipe",
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('teams')->insert([
            'name' => "bresil",
            'flag' => "bresil",
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
        DB::table('teams')->insert([
            'name' => "italie",
            'flag' => "italie",
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
        ]);
    }
}
