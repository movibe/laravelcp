<?php namespace Gcphost\LaravelCP;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\LaravelCP\Comment\CommentRepository',
			'Gcphost\LaravelCP\Comment\EloquentCommentRepository',
			'Gcphost\LaravelCP\Comment\CommentService'
		);
	}
}
