<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Blog\BlogRepository',
			'Gcphost\Helpers\Blog\EloquentBlogRepository',
			'Gcphost\Helpers\Blog\BlogService'
		);
	}
}
