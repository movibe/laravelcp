<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserprofilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('displayname', 255)->nullable();
            $table->string('website', 160)->nullable();
            $table->string('title', 128)->nullable();
            $table->string('address', 128)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 128)->nullable();
            $table->string('zip', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->string('phone', 128)->nullable();
            $table->string('mobile', 128)->nullable();
            $table->string('taxcode', 128)->nullable();
            $table->string('provider', 255)->nullable();
            $table->string('identifier', 255)->nullable();
            $table->string('webSiteURL', 255)->nullable();
            $table->string('profileURL', 255)->nullable();
            $table->string('photoURL', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('firstName', 255)->nullable();
            $table->string('lastName', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('language', 255)->nullable();
            $table->string('age', 255)->nullable();
            $table->string('birthDay', 255)->nullable();
            $table->string('birthMonth', 255)->nullable();
            $table->string('birthYear', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('emailVerified', 255)->nullable();
            $table->timestamp('created_at')->default("0000-00-00 00:00:00");
            $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
            $table->string('region', 255)->nullable();
            $table->string('username', 255)->nullable();
            $table->string('coverInfoURL', 255)->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_profiles');
    }

}