<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class SiteBlogServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\SiteBlog\SiteBlogService'
		);
	}
}
