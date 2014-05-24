<?php 
use Gcphost\LaravelCP\User\UserRepository as User;

class MergeService {
	protected $user;
    protected $role;
    protected $permission;

    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

	public function get()
    {
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$mergefrom='';
		$mergelist=array();

		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=$this->user->find($id);
				if(!empty($user)){
					if($mergefrom){
						$mergelist[$id]=$user->email;
					}else $mergefrom=$user->email;
				}
			}
		}

        return Theme::make('admin/users/confirm_merge', compact('mergelist','mergefrom'));
    }

    public function post()
    {
		return LaravelCP::merge();
	}

}