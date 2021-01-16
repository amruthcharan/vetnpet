<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new \App\User([
            'name'=>'Amruth Charan',
            'email'=>'amruthcharan1@gmail.com',
            'password'=>bcrypt('123456'),
            'role_id'=>1,
            'is_active'=>1
        ]);
        $user->save();
        $user = new \App\User([
            'name'=>'Naga',
            'email'=>'naga@gmail.com',
            'password'=>bcrypt('123456'),
            'role_id'=>2,
            'is_active'=>1
        ]);
        $user->save();
    }
}
