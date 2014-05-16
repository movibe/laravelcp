<?php
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function delete()
    {
		$id=$this->id;
		if(! parent::delete()) return false;
		return empty($this->find($id)) ? true : false;
    } 

    public function validateRoles( array $roles )
    {
        $user = Confide::user();
        $roleValidation = new stdClass();
        foreach( $roles as $role )
        {
            // Make sure theres a valid user, then check role.
            $roleValidation->$role = ( empty($user) ? false : $user->hasRole($role) );
        }
        return $roleValidation;
    }
}