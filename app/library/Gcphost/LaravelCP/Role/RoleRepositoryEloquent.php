<?php namespace Gcphost\LaravelCP\Role;

use Carbon,Input, Role,DB;

class EloquentRoleRepository implements RoleRepository
{
	public $modelClassName="Role";
	public $id;

	public function __construct(Role $role)
    {
        $this->role = $role;
    }

	public function createOrUpdate($id = null, $permissions)
    {
        if(is_null($id))
		{
            $role = new Role;
        } else $role = Role::find($id);

		$role->name = Input::get('name');
		$role->access = Input::get('access');
		$role->updateUniques();
		$role->perms()->sync($permissions);
		if ( $role->id ) $this->id=$role->id;

		return $role;
    }

	public function all(){
		return Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at'));
	}

	public function find($id, $columns = array('*'))
	{
		return Role::find($id);
	}
	
	public function delete($id)
	{
		return Role::delete($id);
	}

	public function __call($method, $args)
    {
        return call_user_func_array([$this->role, $method], $args);
    }

}