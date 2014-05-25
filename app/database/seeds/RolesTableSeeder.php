<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->access = 'admin';
        $adminRole->save();

        $commentRole = new Role;
        $commentRole->name = 'site_user';
        $commentRole->save();

        $clientRole = new Role;
        $clientRole->name = 'client';
        $clientRole->access = 'client';
        $clientRole->save();

        $managerRole = new Role;
        $managerRole->name = 'manager';
        $managerRole->access = 'admin';
        $managerRole->save();


        $user = User::where('email','=','test@example.org')->first();
        $user->attachRole( $commentRole );

    }

}
