<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class SiteBlogServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\SiteBlog\SiteBlogService'
		);
	}
}
