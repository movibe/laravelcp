<?php namespace Gcphost\Helpers\User;

use Confide,UserNotes,UserProfile,Input,User, DB;

class EloquentUserRepository implements UserRepository
{
	public $modelClassName="User";
	public $id;

	public function __construct(User $user)
    {
        $this->user = $user;
    }


	public function createOrUpdate($id = null)
    {
        if(is_null($id)) {
            $user = new User;
			$user->displayname = Input::get( 'displayname' );
			$user->email = Input::get( 'email' );
			$user->password = Input::get( 'password' );
			$user->password_confirmation = Input::get( 'password_confirmation' );
			$user->confirmed = Input::get( 'confirm' );
			$user->save();

			if ( $user->id )
			{
				$this->id=$user->id;
				$user->saveRoles(Input::get( 'roles' ));
				$pro=Input::get('user_profiles');
				$profile = new UserProfile($pro['new']);
				$user = $user->find($user->id);
				$user->profiles()->save($profile);
			} else return false;
			return true;
        }
        else {
			$user = User::find($id);
			$oldUser = clone $user;
            $user->displayname = Input::get( 'displayname' );
            $user->email = Input::get( 'email' );
            $user->confirmed = Input::get( 'confirm' );
            
            $user->prepareRules($oldUser, $user);

			if($user->confirmed == null) $user->confirmed = $oldUser->confirmed;
            
            if(!empty(Input::get( 'password' ))) {
				$user->password = Input::get( 'password' );
				$user->password_confirmation = Input::get( 'password_confirmation' );
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            if(!$user->amend()) return false;

            $user->saveRoles(Input::get( 'roles' ));

			foreach(Input::get('user_profiles') as $id=>$profile){
				$pro = UserProfile::find($id);
				if(!empty($pro)){
					$pro->fill($profile)->push();
				} else {
					$pro = new UserProfile($profile);
					if($pro->title) $user->profiles()->save($pro);
				}
			}

			foreach(Input::get('user_notes') as $id=>$note){
				$not = UserNotes::find($id);
				if(!empty($not)){
					if($note){
						$not->fill(array('id'=>$id,'note'=>$note))->push();
					} else $not->delete();
				} else {
					$not = new UserNotes(array('id'=>$id,'note'=>$note, 'admin_id' =>Confide::user()->id));
					$user->notes()->save($not);
				}
			}
			
			return true;
        }
    }



	public function all($type=null){
		$results=User::leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
                    ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
                    ->select(DB::raw('users.id, users.displayname,users.email, group_concat(roles.name SEPARATOR \', \') as rolename'))
					->groupBy(DB::raw('users.id , users.displayname , users.email'));
		if($type === false || $type == true) $results->where('roles.name', $type ? '=' : '!=', 'admin');
		return $results;
	}

	public function find($id, $columns = array('*'))
	{
		return User::find($id);
	}
	
	public function delete($id)
	{
		return User::delete($id);
	}


	public function __call($method, $args)
    {
        return call_user_func_array([$this->user, $method], $args);
    }


	public function clients($query=false, $limit='10', $page='0', $id=false, $admins=null){
		$users=self::all($admins);
		if($query) $users->where('displayname', 'LIKE', '%'.$query.'%');
		if($id){
			if(preg_match('/,/s', $id)) return $users->whereIn('users.id', explode(',',$id))->get();
			return $users->where('users.id', '=', $id)->first();
		}
		return $users->paginate($limit);
	}

}