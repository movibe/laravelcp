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
        $adminRole->access = 'client';
        $clientRole->save();

        $adminRole = new Role;
        $adminRole->name = 'manager';
        $adminRole->access = 'admin';
        $adminRole->save();


        $user = User::where('email','=','admin@example.org')->first();
        $user->attachRole( $adminRole );

        $user = User::where('email','=','user@example.org')->first();
        $user->attachRole( $commentRole );

        $user = User::where('email','=','client@example.org')->first();
        $user->attachRole( $clientRole );
    }

}
