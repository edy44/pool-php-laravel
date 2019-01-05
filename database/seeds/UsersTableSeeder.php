<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'name' => "admin",
            'email' => "admin@admin.com",
            'password'=>'$2y$10$Xa5AbMR6q2DyBKFyzy3SV.I7Z1.IcJDwxIVR/zcKTxoIWsrxv7l8i',
            'created_at'=> date("Y-m-d h:i:s"),
            'updated_at'=> date("Y-m-d h:i:s"),
            'admin'=>'admin',
            ]);
    }
}
