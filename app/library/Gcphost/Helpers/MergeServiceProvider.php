<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class MergeServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Merge\MergeService'
		);
	}
}
