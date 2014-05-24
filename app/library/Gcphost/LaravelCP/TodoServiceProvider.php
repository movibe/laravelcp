<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Todo\TodoRepository',
			'Gcphost\LaravelCP\Todo\EloquentTodoRepository',
			'Gcphost\LaravelCP\Todo\TodoService'
		);
	}
}
