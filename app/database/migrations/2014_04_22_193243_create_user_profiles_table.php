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
            $table->string('displayname', 255);
            $table->string('website', 160);
            $table->timestamp('updated_at')->default("CURRENT_TIMESTAMP");
            $table->timestamp('created_at')->default("0000-00-00 00:00:00");
            $table->string('title', 128);
            $table->string('address', 128);
            $table->string('city', 128);
            $table->string('state', 128);
            $table->string('zip', 128);
            $table->string('country', 128);
            $table->string('phone', 128);
            $table->string('mobile', 128);
            $table->string('taxcode', 128);
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