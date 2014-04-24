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
		$error=$profile->delete();
        if($error == 1) {
           	return Response::json(array('result'=>'success'));
        } else {
            return Response::json(array('result'=>'failure', 'error' =>   Lang::get('admin/users/messages.edit.error')));
        }
	}

}
