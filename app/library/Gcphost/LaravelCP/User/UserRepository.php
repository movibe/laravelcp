<?php namespace Gcphost\LaravelCP\User;

interface UserRepository
{

	public function all($type=null);
	public function find($id, $columns = array('*'));
	public function clients($query=false, $limit='10', $page='0', $id=false, $admins=null);
	public function delete($id);
}