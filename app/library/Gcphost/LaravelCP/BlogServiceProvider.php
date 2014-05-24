<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Blog\BlogRepository',
			'Gcphost\LaravelCP\Blog\EloquentBlogRepository',
			'Gcphost\LaravelCP\Blog\BlogService'
		);
	}
}
