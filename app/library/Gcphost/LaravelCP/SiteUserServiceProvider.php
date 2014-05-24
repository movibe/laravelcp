<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class SiteUserServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\SiteUser\SiteUserService'
		);
	}
}
