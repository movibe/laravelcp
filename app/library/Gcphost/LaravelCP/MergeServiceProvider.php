<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class MergeServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Merge\MergeService'
		);
	}
}
