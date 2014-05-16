<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Todo\TodoRepository',
			'Gcphost\Helpers\Todo\EloquentTodoRepository'
		);
	}
}
