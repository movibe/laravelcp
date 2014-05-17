<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Search\SearchService'
		);
	}
}
