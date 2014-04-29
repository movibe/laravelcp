<?php

use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function($table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->string('title', 255);
            $table->longText('description')->nullable();
			$table->timestamp('due_at')->default("0000-00-00 00:00:00");
			$table->timestamp('created_at')->default("0000-00-00 00:00:00");
            $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('todos');
    }

}