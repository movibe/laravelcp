<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Role\RoleRepository',
			'Gcphost\LaravelCP\Role\EloquentRoleRepository',
			'Gcphost\LaravelCP\Role\RoleService'

		);
	}
}
