<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\User\UserRepository',
			'Gcphost\LaravelCP\User\EloquentUserRepository',
			'Gcphost\LaravelCP\User\UserService'
		);
	}
}
