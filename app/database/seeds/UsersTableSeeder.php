<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();


        $users = array(
            array(
                'email'      => 'test@example.org',
                'displayname'      => 'Test User',
                'username'      => 'test@example.org',
                'password'   => Hash::make('test'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
            ),

        );

        DB::table('users')->insert( $users );

    }

}