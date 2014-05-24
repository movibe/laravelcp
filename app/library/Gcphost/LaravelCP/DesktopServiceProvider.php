<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class DesktopServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Desktop\DesktopService'
		);
	}
}
