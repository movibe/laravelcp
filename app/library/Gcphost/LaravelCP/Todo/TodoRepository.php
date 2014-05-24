<?php namespace Gcphost\LaravelCP\Todo;

interface TodoRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}