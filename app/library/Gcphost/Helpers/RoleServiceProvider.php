<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Role\RoleRepository',
			'Gcphost\Helpers\Role\EloquentRoleRepository',
			'Gcphost\Helpers\Role\RoleService'

		);
	}
}
