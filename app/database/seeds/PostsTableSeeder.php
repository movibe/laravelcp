<?php

class PostsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('posts')->delete();

        $user_id = User::first()->id;

        DB::table('posts')->insert( array(
            array(
                'user_id'    => $user_id,
                'title'      => 'Home',
                'slug'       => 'home',
                'content'    => '',
                'meta_title' => 'meta_title1',
                'meta_description' => 'meta_description1',
                'meta_keywords' => 'meta_keywords1'
                //'created_at' => new DateTime,
                //'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                'title'      => 'About Us',
                'slug'       => 'about-us',
                'content'    => 'About us content..',
                'meta_title' => 'meta_title2',
                'meta_description' => 'meta_description2',
                'meta_keywords' => 'meta_keywords2',
                //'created_at' => new DateTime,
                //'updated_at' => new DateTime,
            )
		)
        );
    }

}
