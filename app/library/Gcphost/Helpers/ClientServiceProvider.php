<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\User\ClientService'
		);
	}
}
