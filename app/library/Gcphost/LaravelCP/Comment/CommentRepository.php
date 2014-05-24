<?php namespace Gcphost\LaravelCP\Comment;

interface CommentRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}