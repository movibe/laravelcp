<?php namespace Gcphost\LaravelCP\Blog;

interface BlogRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}