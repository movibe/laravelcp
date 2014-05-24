<?php 

class ProfileService {
	protected $user;
    protected $role;
    protected $permission;
	private $email;

	public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;

    }

    public function delete($user, $profile)
    {
		return $this->user->deleteProfile($profile) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
	}

}