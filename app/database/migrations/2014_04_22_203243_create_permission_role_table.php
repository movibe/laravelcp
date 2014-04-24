<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermissionroleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function($table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
 			//$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			//$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }

}