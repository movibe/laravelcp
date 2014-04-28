<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
	
    }


	public function runCancel($job, $data){
		DB::table('users')->where('id', $data['id'])->update(array('confirmed' => false, 'cancelled' => true));
	}


	public function getCancel($user, $token){
		switch($token){
			case 'now':
				$this->runCancel('', array('id' => $user->id));
			break;
			case 'later':
				$date = Carbon::now()->addMinutes(15);
				Queue::later($date, 'UserController@runCancel', array('id' => $user->id));
			break;
			case 'tomorrow':
				$date = Carbon::tomorrow();
				Queue::later($date, 'UserController@runCancel', array('id' => $user->id));
			break;
			case 'disable':
				if($user->cancelled) DB::table('users')->where('id', $user->id)->update(array('confirmed' => true, 'cancelled' => false));
			break;
		}
		return Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') );
	}


    public function invalidtoken()
    {
        return View::make('site/invalidtoken');
    }     
    public function noPermission()
    {
        return View::make('site/nopermission');
    }
    public function suspended()
    {
        return View::make('site/suspended');
    }
	

	/**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}
		$profiles=$user->profiles;


        // Show the page
        return View::make('site/user/index', compact('user', 'profiles'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
		$rules = array(
			'terms'     => "required|accepted",
			'email'     => "required|email",
			'create_hp'   => 'honeypot',
			'create_hp_time'   => 'required|honeytime:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{

			$this->user->email = Input::get( 'email' );
			$this->user->displayname = Input::get( 'name' );

			$password = Input::get( 'password' );
			$passwordConfirmation = Input::get( 'password_confirmation' );

			if(!empty($password)) {
				if($password === $passwordConfirmation) {
					$this->user->password = $password;
					$this->user->password_confirmation = $passwordConfirmation;
				} else {
					return Redirect::to('user/create')
						->withInput(Input::except('password','password_confirmation'))
						->with('error', Lang::get('admin/users/messages.password_does_not_match'))->withErrors($validator);
				}
			} else {
				unset($this->user->password);
				unset($this->user->password_confirmation);
			}

			$this->user->save();

			if ( $this->user->id )
			{
				$user=User::find($this->user->id);
				$user->saveRoles(array(Setting::get('users.default_role_id')));

				return Redirect::to('user/login')->with( 'emailvalidation', Lang::get('user/user.user_account_created') );
			}
			else
			{
				$error = $this->user->errors()->all();

				return Redirect::to('user/create')
					->withInput(Input::except('password'))
					->with( 'error', $error )->withErrors($validator);
			}
		} else return Redirect::to('user/create')
					->withInput(Input::except('password'))
					->withErrors($validator);
    }

    /**
     * Edits a user
     *
     */
    public function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->email = Input::get( 'email' );
            $user->displayname = Input::get( 'displayname' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->prepareRules($oldUser, $user);

            // Save if valid. Password field will be hashed before save
            $user->amend();

			foreach(Input::get('user_profiles') as $id=>$profile){
				$pro = UserProfile::find($id);
				if($pro){
					$pro->fill($profile)->push();
				} else {
					$pro = new UserProfile($profile);
					if($pro->title) $user->profiles()->save($pro);
				}
			}


        } else {
            return Redirect::to('user')->withInput(Input::except('password','password_confirmation'))->with( 'error', 'Validation failed' );
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            return Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')->withInput(Input::except('password','password_confirmation'))->with( 'error', $error );
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
 		$anvard = App::make('anvard');
		$providers = $anvard->getProviders();

		return View::make('site/user/create', compact('providers'));
    }

    public function getDelete($user, $profile)
    {
		$error=$profile->delete();
        if($error == 1) {
            return Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')->with( 'error', Lang::get('user/user.user_account_not_updated') );
        }
	}


    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
		$user = Auth::user();
		if(!empty($user->id)) return Redirect::to('/');
		
		$anvard = App::make('anvard');
		$providers = $anvard->getProviders();

		return View::make('site/user/login', compact('providers'));
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );

        if ( Confide::logAttempt( $input, true ) )
        {

			DB::update('UPDATE users SET last_login = ? WHERE id = ?', array(date( 'Y-m-d H:i:s', time() ), Auth::user()->id));
			Activity::log(array(
				'contentID'   => Confide::user()->id,
				'contentType' => 'login',
				'description' => 'User logged in',
				'details'     => gethostbyaddr($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] .' ('.gethostbyaddr($_SERVER['REMOTE_ADDR']).')' : $_SERVER['REMOTE_ADDR'],
				'updated'     => Confide::user()->id ? true : false,
			));

            $r = Session::get('loginRedirect');
            if (!empty($r))
            {
                Session::forget('loginRedirect');
                return Redirect::to($r);
            }
            return Redirect::to('/admin');
        }
        else
        {
            // Check if there was too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );
        }
        else
        {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            return Redirect::to('user/login')
            ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );
        }
        else
        {
            return Redirect::to('user/reset/'.$input['token'])
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }



    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
}
