<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;
use Zizaco\Entrust\HasRole;
use Carbon\Carbon;

class User extends ConfideUser {
    use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
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
		return empty($this->find($id));

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



    /**
     * Get the date the user was created.
     *
     * @return string
     */
    public function joined()
    {
        return String::date(Carbon::createFromFormat('Y-n-j G:i:s', $this->created_at));
    }

    /**
     * Save roles inputted from multiselect
     * @param $inputRoles
     */
    public function saveRoles($inputRoles)
    {
        if(! empty($inputRoles)) {
            $this->roles()->sync($inputRoles);
        } else {
            $this->roles()->detach();
        }
    }

    /**
     * Save profiles inputted from multiselect
     * @param $inputRoles
     */
    public function saveProfiles($inputProfile)
    {
        if(! empty($inputProfile)) {
            $this->profiles()->sync($inputProfile);
        } else {
            $this->profiles()->detach();
        }
    }
    /**
     * Returns user's current role ids only.
     * @return array|bool
     */
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

    /**
     * Redirect after auth.
     * If ifValid is set to true it will redirect a logged in user.
     * @param $redirect
     * @param bool $ifValid
     * @return mixed
     */
    public static function checkAuthAndRedirect($redirect, $ifValid=false)
    {
        // Get the user information
        $user = Auth::user();
        $redirectTo = false;
        if(empty($user->id) && ! $ifValid) // Not logged in redirect, set session.
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


}
