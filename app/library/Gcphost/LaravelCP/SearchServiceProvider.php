<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Search\SearchService'
		);
	}
}
