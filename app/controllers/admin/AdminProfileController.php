<?php
use Illuminate\Filesystem\Filesystem;
class AdminProfileController extends AdminController {


    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;

	private $email;

    /**
     * Inject the models.
     * @param User $user
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;

    }

    public function deleteIndex($user, $profile)
    {
		$id=$profile->id;
		if(!$profile->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$profile=UserProfiles::find($id);
        return empty($profile) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
	}
}
