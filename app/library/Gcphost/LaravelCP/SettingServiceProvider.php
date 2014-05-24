<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Setting\SettingService'
		);
	}
}
