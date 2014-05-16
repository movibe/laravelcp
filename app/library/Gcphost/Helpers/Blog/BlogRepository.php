<?php namespace Gcphost\Helpers\Blog;

interface BlogRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}