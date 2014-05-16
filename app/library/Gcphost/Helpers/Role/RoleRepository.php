<?php namespace Gcphost\Helpers\Role;

interface RoleRepository
{

	public function all();
	public function find($id, $columns = array('*'));
	public function delete($id);
}