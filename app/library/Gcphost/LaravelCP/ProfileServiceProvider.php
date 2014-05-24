<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Profile\ProfileService'
		);
	}
}
