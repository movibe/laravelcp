<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();


        $users = array(
            array(
                'email'      => 'admin@example.org',
                'displayname'      => 'admin@example.org',
                'username'      => 'admin@example.org',
                'password'   => Hash::make('admin'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
            ),
            array(
                'email'      => 'user@example.org',
                 'displayname'      => 'admin@example.org',
                  'username'      => 'admin@example.org',
             'password'   => Hash::make('user'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
            )
        );

        DB::table('users')->insert( $users );
    }

}
