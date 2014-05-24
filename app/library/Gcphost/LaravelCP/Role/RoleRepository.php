<?php namespace Gcphost\LaravelCP\Role;

interface RoleRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}