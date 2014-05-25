<?php
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public static $rules = array(
		'name'   => 'unique:roles|required|min:3|max:70',
    );

	public static $protected = array(
		'admin',
		'client',
		'site_user'
	);

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

	public function byName($name){
		return $this->where('name', '=', $name)->first();
	}
}