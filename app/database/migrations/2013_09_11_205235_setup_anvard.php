<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupAnvard extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Config::get('anvard::db.profilestable'), function(Blueprint $t)
        {
            // Create the profiles table, and link it to the users table
            $t->string('provider');
            $t->string('identifier');
            $t->string('webSiteURL')->nullable(); 
            $t->string('profileURL')->nullable();
            $t->string('photoURL')->nullable();
            $t->text('description')->nullable();
            $t->string('firstName')->nullable();
            $t->string('lastName')->nullable();
            $t->string('gender')->nullable();
            $t->string('language')->nullable();
            $t->string('age')->nullable();
            $t->string('birthDay')->nullable();
            $t->string('birthMonth')->nullable();
            $t->string('birthYear')->nullable();
            $t->string('email')->nullable();
            $t->string('emailVerified')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Config::get('anvard::db.profilestable'));
    }

}