<?php namespace Gcphost\Helpers\User;

use Setting,Redirect,Session,Event,Activity,Auth,Confide,UserNotes,UserProfile,Input,User, DB;

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
        } else {
			$user = User::find($id);
			$oldUser = clone $user;
            $user->displayname = Input::get( 'displayname' );
            $user->email = Input::get( 'email' );
            $user->confirmed = Input::get( 'confirm' );
            
            $user->prepareRules($oldUser, $user);

			if($user->confirmed == null) $user->confirmed = $oldUser->confirmed;
            $pw=Input::get( 'password' );
            if(!empty($pw)) {
				$user->password = Input::get( 'password' );
				$user->password_confirmation = Input::get( 'password_confirmation' );
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            if(!$user->save()) return false;

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
				} elseif($note) {
					
					$not = new UserNotes(array('id'=>$id,'note'=>$note, 'admin_id' =>Confide::user()->id));
					$user->notes()->save($not);
				}
			}
			
			Event::fire('controller.user.create', array($this->user));
			Activity::log(array(
				'contentID'   => $this->user->id,
				'contentType' => 'account_created',
				'description' => $this->user->id,
				'details'     => 'account_created',
				'updated'     => Confide::user()->id ? true : false,
			));


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

	public function logout(){
		Event::fire('user.logout', array(Confide::user()));
 
		Activity::log(array(
			'contentID'   => Confide::user()->id,
			'contentType' => 'logout',
			'description' => Confide::user()->id,
			'details'     => '',
			'updated'     => Confide::user()->id,
		));

		Confide::logout();
	}

	public function updateLogin($input){
		DB::update('UPDATE users SET last_login = ? WHERE id = ?', array(date( 'Y-m-d H:i:s', time() ), Auth::user()->id));
		Activity::log(array(
			'contentID'   => Confide::user()->id,
			'contentType' => 'login',
			'description' => 'info',
			'details'     => gethostbyaddr($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] .' ('.gethostbyaddr($_SERVER['REMOTE_ADDR']).')' : $_SERVER['REMOTE_ADDR'],
			'updated'     => Confide::user()->id ? true : false,
		));

		Event::fire('user.login', array($input));
		

		$r = Session::get('loginRedirect');
		if(empty($r)){
			foreach( Auth::user()->roles as $role )
			{
				switch($role->name){
					case 'client':
						$r= Setting::get('login.login_url') ? Setting::get('login.login_url') : '/';
					break;

					case 'admin':
						$r='/admin';
					break;

					case 'site_user':
						$r= Setting::get('login.login_url') ? Setting::get('login.login_url') : '/';
					break;

					default:
						$r= Setting::get('login.login_url') ? Setting::get('login.login_url') : '/';
					break;
				}
			}
		} else Session::forget('loginRedirect');

		return Redirect::to($r);
	}

	public function publicCreateOrUpdate($id = null)
    {
        if(is_null($id)) {
            $user = new User;
			$user->displayname = Input::get( 'displayname' );
			$user->email = Input::get( 'email' );
			$user->password = Input::get( 'password' );
			$user->password_confirmation = Input::get( 'password_confirmation' );
			$user->save();

			if ( $user->id )
			{
				$this->id=$user->id;
				$user->saveRoles(array(Setting::get('users.default_role_id')));
			} else return false;

			Activity::log(array(
				'contentID'   => $user->id,
				'contentType' => 'account_created',
				'description' => $user->id,
				'details'     => 'Created from site',
				'updated'     => false,
			));

			Event::fire('user.create', array($user));

			return true;
        }
        else {
			$user = User::find($id);
			$oldUser = clone $user;
            $user->displayname = Input::get( 'displayname' );
            $user->email = Input::get( 'email' );
            
            $user->prepareRules($oldUser, $user);

            $pw=Input::get( 'password' );
            if(!empty($pw)) {
				$user->password = Input::get( 'password' );
				$user->password_confirmation = Input::get( 'password_confirmation' );
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            if(!$user->save()) return false;

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
			
			Event::fire('user.edit', array($user));

			return true;
        }
	}


}