<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->save();

        $commentRole = new Role;
        $commentRole->name = 'comment';
        $commentRole->save();

        $user = User::where('email','=','admin@example.org')->first();
        $user->attachRole( $adminRole );

        $user = User::where('email','=','admin@example.org')->first();
        $user->attachRole( $commentRole );
    }

}
