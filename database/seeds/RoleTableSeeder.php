<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new \App\Role([
            'name'=>'Admin'
        ]);
        $role->save();
        $role = new \App\Role([
            'name'=>'Doctor'
        ]);
        $role->save();
        $role = new \App\Role([
            'name'=>'Receptionist'
        ]);
        $role->save();
    }
}
