<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\User\UserRepository',
			'Gcphost\Helpers\User\EloquentUserRepository'
		);
	}
}
