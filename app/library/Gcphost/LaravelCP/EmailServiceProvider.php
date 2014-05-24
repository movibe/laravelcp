<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Email\EmailService'
		);
	}
}
