<?php
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;
use Zizaco\Entrust\HasRole;
use Carbon\Carbon;

class User extends ConfideUser {
    use HasRole;

	protected $table = 'users';

	public static $rules = array(
        'email' => 'required|email',
        'password' => 'min:4|confirmed',
        'password_confirmation' => 'min:4',
    );

	public function profiles()
    {
        return $this->hasMany('UserProfile');
    }

	public function notes()
    {
        return $this->hasMany('UserNotes');
    }

	public function assignedroles()
    {
        return $this->hasMany('AssignedRole');
    }
	public function posts()
    {
        return $this->hasMany('Post');
    }

	public function deleteProfile($profile){
		$id=$profile->id;
		if(!$profile->delete()) return false;
		$profile=UserProfile::find($id);
        return empty($profile);
	}

    public function delete()
    {
        if ($this->id === $this->currentUser()->id)
        {
            return false;
        }

		$id=$this->id;

		Activity::log(array(
			'contentID'   => $this->id,
			'contentType' => 'account_deleted',
			'description' => $this->id,
			'details'     => '',
			'updated'     => $this->currentUser()->id ? true : false,
		));

		Event::fire('controller.user.delete', array($this));
       
		if(! parent::delete()) return false;
		return empty($this->find($id)) ? true : false;
    } 

	public function emails()
    {
		return Activity::whereRaw('user_id = ? AND content_type="email"', array($this->id))->select(array('user_id','description', 'details','ip_address', 'updated_at'))->orderBy('id', 'DESC');
	}

	public function lastlogin(){
		return Activity::whereRaw('user_id = ? AND content_type="login"', array($this->id))->select(array('details'))->orderBy('id', 'DESC')->first();

	}

	public function activity()
    {
		return Activity::whereRaw('user_id = ? AND content_type="activity"', array($this->id))->select(array('user_id','description', 'details','ip_address', 'updated_at'))->orderBy('id', 'DESC');
	}

	public function getnotes(){
		return UserNotes::leftjoin('users', 'users.id', '=', 'user_notes.admin_id')
					->select(array('user_notes.id', 'user_notes.note', 'user_notes.created_at', 'user_notes.updated_at', 'users.displayname'))->where('user_notes.user_id','=',$this->id)->orderBy('users.id');
	}

	public function merge($user){
		DB::update('UPDATE user_profiles set user_id = ? where user_id = ?', array($this->id, $user->id));
		DB::update('UPDATE posts set user_id = ? where user_id = ?', array($this->id, $user->id));
		DB::update('UPDATE comments set user_id = ? where user_id = ?', array($this->id, $user->id));
		DB::update('UPDATE activity_log set user_id = ? where user_id = ?', array($this->id, $user->id));
		DB::table('assigned_roles')->where('user_id', '=', $this->id)->delete();

		Event::fire('controller.user.merge', array($user));

		return $user->delete();
	}

    public function joined()
    {
        return String::date(Carbon::createFromFormat('Y-n-j G:i:s', $this->created_at));
    }

    public function saveRoles($inputRoles)
    {
        if(! empty($inputRoles)) {
            $this->roles()->sync($inputRoles);
        } else {
            $this->roles()->detach();
        }
    }

    public function saveProfiles($inputProfile)
    {
        if(! empty($inputProfile)) {
            $this->profiles()->sync($inputProfile);
        } else {
            $this->profiles()->detach();
        }
    }

	public function currentRoleIds()
    {
        $roles = $this->roles;
        $roleIds = false;
        if( !empty( $roles ) ) {
            $roleIds = array();
            foreach( $roles as &$role )
            {
                $roleIds[] = $role->id;
            }
        }
        return $roleIds;
    }

	public static function checkAuthAndRedirect($redirect, $ifValid=false)
    {
        $user = Auth::user();
        $redirectTo = false;
        if(empty($user->id) && ! $ifValid) 
        {
            Session::put('loginRedirect', $redirect);
            $redirectTo = Redirect::to('user/login')
                ->with( 'success', Lang::get('user/user.login_first') );
        }
        elseif(!empty($user->id) && $ifValid) // Valid user, we want to redirect.
        {
            $redirectTo = Redirect::to($redirect);
        }

        return array($user, $redirectTo);
    }

    public function currentUser()
    {
        return (new Confide(new ConfideEloquentRepository()))->user();
    }

	public function chart(){
		$chart = Lava::DataTable('activeusers');
		$chart->addColumn('string', 'Active', 'active');
		$chart->addColumn('string', 'Inactive', 'inactive');

		$chart->addRow(array('Active',DB::table('users')->where('confirmed', '=', '1')->count()));
		$chart->addRow(array('In-active',DB::table('users')->where('confirmed', '!=', '1')->count()));

		Lava::PieChart('activeusers')->addOption(array('chartArea' => array('width'=>'98%', 'height'=>'98%')))->addOption(array('backgroundColor' => 'none'))->addOption(array('is3D' => 'true'))->addOption(array('legend' => 'none'));
	}	
}