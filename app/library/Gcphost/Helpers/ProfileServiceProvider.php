<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Profile\ProfileService'
		);
	}
}
