<?php
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

	public function validateRoles( array $roles )
    {
        $user = Confide::user();
        $roleValidation = new stdClass();
        foreach( $roles as $role )
        {
            $roleValidation->$role = ( empty($user) ? false : $user->hasRole($role) );
        }
        return $roleValidation;
    }

    public function delete()
    {
		$id=$this->id;
		if(! parent::delete()) return false;
		return !$this->find($id) ? true : false;
    } 
}