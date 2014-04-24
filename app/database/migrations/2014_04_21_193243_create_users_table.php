<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('confirmation_code', 255);
            $table->boolean('confirmed');
            $table->timestamp('created_at')->default("0000-00-00 00:00:00");
            $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
            $table->timestamp('last_activity')->default("0000-00-00 00:00:00");
            $table->timestamp('last_login')->default("0000-00-00 00:00:00");
            $table->string('displayname', 256);
            $table->string('username', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}