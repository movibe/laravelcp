<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class DesktopServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Desktop\DesktopService'
		);
	}
}
