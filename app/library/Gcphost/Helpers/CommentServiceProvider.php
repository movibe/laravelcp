<?php namespace Gcphost\Helpers;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Gcphost\Helpers\Comment\CommentRepository',
			'Gcphost\Helpers\Comment\EloquentCommentRepository'
		);
	}
}
