<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\User\ClientService'
		);
	}
}
