<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Email\EmailService'
		);
	}
}
