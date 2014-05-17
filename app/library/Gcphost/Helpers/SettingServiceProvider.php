<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Setting\SettingService'
		);
	}
}
