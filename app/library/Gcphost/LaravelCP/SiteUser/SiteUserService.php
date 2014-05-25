<?php 
use Gcphost\LaravelCP\User\UserRepository as User;

class SiteUserService {
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

	public function cancel($user, $token){
		$user->cancel($token);
		return Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') );
	}

    public function invalidtoken()
    {
        return Theme::make('site/invalidtoken');
    }   
	
    public function noPermission()
    {
        return Theme::make('site/nopermission');
    }

    public function suspended()
    {
        return Theme::make('site/suspended');
    }
	
    public function index()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect) return $redirect;
		$profiles=$user->profiles;

        return Theme::make('site/user/index', compact('user', 'profiles'));
    }

    public function post()
    {
		$rules = array(
			'displayname' => 'required|max:70',
			'terms'     => "required|accepted",
			'email'     => "required|email|max:254",
			'password'   => 'required|confirmed|min:4',
			'create_hp'   => 'honeypot',
			'create_hp_time'   => 'required|honeytime:3'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes())
		{
			$save=$this->user->publicCreateOrUpdate();
			$errors = $save->errors();

			return count($errors->all()) == 0 ?
				Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_created') ) :
				Redirect::to('user/create')->withInput(Input::except('password','password_confirmation'))->withErrors($errors );
		} else return Redirect::to('user/create')
					->withInput(Input::except('password','password_confirmation'))
					->withErrors($validator);
    }

    public function edit($user)
    {
		if(!Input::get( 'password' )) {
			$rules = array(
				'displayname' => 'required',
				'email' => 'required|email',
				'password' => 'min:4|confirmed',
				'password_confirmation' => 'min:4'
			);
		} else {
			$rules = array(
				'displayname' => 'required',
				'email' => 'required|email'
			);
		}

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
			$save=$this->user->publicCreateOrUpdate(Auth::user()->id);
			$errors = $save->errors();

			return count($errors->all()) == 0 ?
				Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') ) :
				Redirect::to('user')->withInput(Input::except('password','password_confirmation'))->withErrors($errors);
        } else return Redirect::to('user')->withInput(Input::except('password','password_confirmation'))->withErrors($validator);
    }

    public function getCreate()
    {
		$user = Auth::user();
		if(!empty($user->id)) return Redirect::to('/');

		$anvard = App::make('anvard');
		$providers = $anvard->getProviders();

		return Theme::make('site/user/create', compact('providers'));
    }

    public function getDelete($user, $profile)
    {
        return $user->deleteProfile($profile) ?
            Redirect::to('user')->with( 'success', Lang::get('user/user.user_account_updated') ) : Redirect::to('user')->with( 'error', Lang::get('user/user.user_account_not_updated') );
	}

    public function getLogin()
    {
		$user = Auth::user();
		if(!empty($user->id)) return Redirect::to('/');
		
		$anvard = App::make('anvard');
		$providers = $anvard->getProviders();

		return Theme::make('site/user/login', compact('providers'));
    }

    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ),
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' )
        );

        if ( Confide::logAttempt( $input, true ) )
        {
			return $this->user->updateLogin($input);
        }
        else
        {
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');

            return Redirect::to('user/login')->withInput(Input::except('password'))->with( 'error', $err_msg );
        }
    }

    public function getConfirm( $code )
    {
        return Confide::confirm( $code ) ?
            Redirect::to('user/login')->with( 'success', Lang::get('confide::confide.alerts.confirmation') ) :
			Redirect::to('user/login')->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
    }

    public function getForgot()
    {
        return Theme::make('site/user/forgot');
    }

    public function postForgot()
    {
        return Confide::forgotPassword( Input::get( 'email' ) ) ?
            Redirect::to('user/login')->with( 'success', Lang::get('confide::confide.alerts.password_forgot') ) :
			Redirect::to('user/forgot')->withInput()->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
    }

    public function getReset( $token )
    {
        return Theme::make('site/user/reset')->with('token',$token);
    }
  
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' )
        );

        return Confide::resetPassword( $input ) ?
            Redirect::to('user/login')->with( 'success', Lang::get('confide::confide.alerts.password_reset') ) :
            Redirect::to('user/reset/'.$input['token'])->withInput()->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset'));
    }

    public function getLogout()
    {
		$this->user->logout();	   
        return Redirect::to(Setting::get('login.logout_url') ? Setting::get('login.logout_url') : '/');
    }

	public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect) return $redirect;

        return Theme::make('site/user/profile', compact('user'));
    }
}