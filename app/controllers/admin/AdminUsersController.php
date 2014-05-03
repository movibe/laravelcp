<?php
use Illuminate\Filesystem\Filesystem;
class AdminUsersController extends AdminController {

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


    /**
     * User  charts
     *
     * @return Response
     */
	private function userChart(){
		$chart = Lava::DataTable('activeusers');
		$chart->addColumn('string', 'Active', 'active');
		$chart->addColumn('string', 'Inactive', 'inactive');

		$chart->addRow(array('Active',DB::table('users')->where('confirmed', '=', '1')->count()));
		$chart->addRow(array('In-active',DB::table('users')->where('confirmed', '!=', '1')->count()));

		Lava::PieChart('activeusers')->addOption(array('chartArea' => array('width'=>'98%', 'height'=>'98%')))->addOption(array('backgroundColor' => 'none'))->addOption(array('is3D' => 'true'))->addOption(array('legend' => 'none'));
	}



    /**
     * Get index.
     *
     * @return Response
     */
    public function getIndex()
    {
        $users = $this->user;
		$this->userChart();
        $title = Lang::get('admin/users/title.user_management');
       	return Theme::make('admin/users/index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $roles = $this->role->all();
        $permissions = $this->permission->all();
        $selectedRoles = Input::old('roles', array());
        $selectedPermissions = Input::old('permissions', array());
		$mode = 'create';
		$title = Lang::get('admin/users/title.create_a_new_user');
		return Theme::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {

  		$rules = array(
			'displayname'      => 'required',
			'email'      => 'required|email',
			'password'   => 'required|confirmed|min:4'
		);

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
			$this->user->displayname = Input::get( 'displayname' );
			$this->user->email = Input::get( 'email' );
			$this->user->password = Input::get( 'password' );
			$this->user->password_confirmation = Input::get( 'password_confirmation' );
			$this->user->confirmed = Input::get( 'confirm' );
			$this->user->save();

			Event::fire('controller.user.create', array($this->user));

			if ( $this->user->id )
			{
				$this->user->saveRoles(Input::get( 'roles' ));

				$pro=Input::get('user_profiles');
				$profile = new UserProfile($pro['new']);
				$user = User::find($this->user->id);
				$user->profiles()->save($profile);

				Activity::log(array(
					'contentID'   => $this->user->id,
					'contentType' => 'account_created',
					'description' => $this->user->id,
					'details'     => 'account_created',
					'updated'     => Confide::user()->id ? true : false,
				));

				return Api::to(array('success', Lang::get('admin/users/messages.create.success'))) ? : Redirect::to('admin/users/' . $this->user->id . '/edit')->with('success', Lang::get('admin/users/messages.create.success'));
			}
			else return Api::to(array('error', $this->user->errors()->all() )) ? :  Redirect::to('admin/users/create')->withInput(Input::except('password'))->with( 'error', $this->user->errors()->all() );
        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? :  Redirect::to('admin/users/create')->withInput(Input::except('password'))->with('error', Lang::get('admin/users/messages.edit.error'))->withErrors($validator);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
	 public function getActivity($user){
        if ( $user->id )
        {
			$list = Activity::whereRaw('user_id = ? AND content_type="activity"', array($user->id))->select(array('user_id','description', 'details','ip_address', 'updated_at'))->orderBy('id', 'DESC');

			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->make();
		}
	 }

    /**
     * Get emails
     *
     * @return Response
     */
	 public function getEmails($user){
        if ( $user->id )
        {
			$list = Activity::whereRaw('user_id = ? AND content_type="email"', array($user->id))->select(array('user_id','description', 'details','ip_address', 'updated_at'))->orderBy('id', 'DESC');

			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->edit_column('details','{{{ strip_tags(substr($details,0,100))}}}')
				->make();
		}
	 }

    /**
     * reset password
     *
     * @return Response
     */
	public function postResetpassword($user){
		if(!Confide::forgotPassword( $user->email)){
			if(!Api::make(array('error'))) return Response::json(array('result'=>'error'));
		} else if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
	}

    /**
     * edit user
     *
     * @return Response
     */
    public function getEdit($user)
    {
        if ( $user->id )
        {
            $roles = $this->role->all();
			$profiles=$user->profiles;

            $permissions = $this->permission->all();
        	$title = Lang::get('admin/users/title.user_update');
        	$mode = 'edit';

			$last_login = Activity::whereRaw('user_id = ? AND content_type="login"', array($user->id))->select(array('details'))->orderBy('id', 'DESC')->first();

			return Theme::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode', 'profiles', 'last_login'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

    /**
     * get user notes
     *
     * @return Response
     */
    public function getNotes($user)
    {

        if ( $user->id )
        {
			$list = UserNotes::leftjoin('users', 'users.id', '=', 'user_notes.admin_id')
					->select(array('user_notes.id', 'user_notes.note', 'user_notes.created_at', 'user_notes.updated_at', 'users.displayname'))->where('user_notes.user_id','=',$user->id)->orderBy('users.id');
			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('note','<textarea name="user_notes[{{{$id}}}]" class="form-control" style="width: 100%">{{{ $note }}}</textarea>')
				 ->edit_column('created_at','{{{ Carbon::parse($created_at)->diffForHumans() }}}')
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->make();
		}
	}


	/**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
	
    public function putEdit($user)
    {
		
		if(!Input::get( 'password' )) {
			$rules = array(
				'displayname' => 'required',
				'email' => 'required|email',
				'password' => 'min:4|confirmed',
				'password_confirmation' => 'min:4',
			);
		} else {
			$rules = array(
				'displayname' => 'required',
				'email' => 'required|email',
			);
		}

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {

            $oldUser = clone $user;
            $user->displayname = Input::get( 'displayname' );
            $user->email = Input::get( 'email' );
            $user->confirmed = Input::get( 'confirm' );
            
            $user->prepareRules($oldUser, $user);

			if($user->confirmed == null) $user->confirmed = $oldUser->confirmed;
            
            if(!Input::get( 'password' )) {
				$user->password = Input::get( 'password' );
				$user->password_confirmation = Input::get( 'password_confirmation' );
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->amend();

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

			Event::fire('controller.user.edit', array($user));

        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? :  Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($validator);
        

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
           return Api::to(array('success', Lang::get('admin/users/messages.edit.success'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.edit.error'));
    }

    /**
     * merge users
     *
     * @return Response
     */
	private function runMerge($_merge_to, $user){
		DB::update('UPDATE user_profiles set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE posts set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE comments set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE activity_log set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::table('assigned_roles')->where('user_id', '=', $user->id)->delete();

		Event::fire('controller.user.merge', array($user));

		return $user->delete();
	}


    /**
     * post merge users
     *
     * @return Response
     */
    public function postMerge()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			if(count($rows) < 2) return Api::to(array('error',Lang::get('core.mergeerror'))) ? : Response::json(array('result'=>'error', 'error' =>  Lang::get('core.mergeerror')));
			$_merge_to=false;
			foreach($rows as $i=>$r){
				if ($r != Confide::user()->id){
					$user = User::find($r);
					if(!empty($user)){
						if(!$_merge_to){
							$_merge_to=$user;
							continue;
						}
						$this->runMerge($_merge_to, $user);
					} else  return Api::to(array('error', '')) ? : Response::json(array('result'=>'error', 'error' =>  ''));
				}
			}
		}
		if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
    }

    /**
     * delete mass
     *
     * @return Response
     */
	private function runDeleteMass($r){
		if ($r != Confide::user()->id){
			$user = User::find($r);
			if(!empty($user)){
				Event::fire('controller.user.delete', array($user));
				$user->delete();
			} else return Api::to(array('error', '')) ? : Response::json(array('result'=>'error', 'error' =>  ''));
		}
	}


    /**
     * confirm mass 
     *
     * @return Response
     */
    public function getMassMergeConfirm()
    {
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$mergefrom='';
		$mergelist=array();

		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=User::find($id);
				if(!empty($user)){
					if($mergefrom){
						$mergelist[$id]=$user->email;
					}else $mergefrom=$user->email;
				}
			}
		}

        return Theme::make('admin/users/confirm_merge', compact('mergelist','mergefrom'));
    }

    /**
     * post delete mass
     *
     * @return Response
     */
    public function postDeleteMass()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			foreach($rows as $i=>$r) $this->runDeleteMass($r);
		}elseif(is_integer($rows))$this->runDeleteMass($rows);
		if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
	}


    /**
     * Remove the specified user from storage.
     *
     * @param $user
     * @return Response
     */
    public function deleteIndex($user)
    {
        // Check if we are not trying to delete ourselves
        if ($user->id === Confide::user()->id)
        {
            // Redirect to the user management page
            return Api::to(array('error', Lang::get('admin/users/messages.delete.impossible'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

		$id=$user->id;

		Activity::log(array(
			'contentID'   => $user->id,
			'contentType' => 'account_deleted',
			'description' => $user->id,
			'details'     => '',
			'updated'     => Confide::user()->id ? true : false,
		));


		Event::fire('controller.user.delete', array($user));

		if(!$user->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$user=User::find($id);
        return empty($user) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
        
    }

    /**
     * fetch email templates
     *
     * @return Response
     */
	private function emailTemplates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.Theme::getTheme().DIRECTORY_SEPARATOR."emails");
		return $files;
	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getEmail($user)
    {
        if ( $user->id )
        {
            // Title
        	$title = $user->email;
        	// mode
        	$mode = 'edit';
			$templates=$this->emailTemplates();
        	return Theme::make('admin/users/send_email', compact('user', 'title', 'mode', 'templates'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

     /**
     * send a mail
     *
     * @return Response
     */
	private function sendEmail($user, $template='emails.default'){
		//if (!View::exists($template))$template='emails.default';
		
		Event::fire('controller.user.email', array($user));

		$this->email=$user->email;

		try{
			$send=Mail::send($template, array('body'=>Input::get('body'), 'user' => $user), function($message)
			{
				$message->to($this->email)->subject(Input::get('subject'));

				$files=Input::file('email_attachment');
				if(count($files) > 1){
					foreach($files as $file) $message->attach($file->getRealPath(), array('as' => $file->getClientOriginalName(), 'mime' => $file->getMimeType()));
				} elseif(count($files) == 1) $message->attach($files->getRealPath(), array('as' => $files->getClientOriginalName(), 'mime' => $files->getMimeType()));

			});

			Activity::log(array(
				'contentID'   => $user->id,
				'contentType' => 'email',
				'description' => Input::get('subject'),
				'details'     => Input::get('body'),
				'updated'     => $user->id ? true : false,
			));

		} catch (Exception $e) {
			return false;
		}

		return $send;

	}


    /**
     * post mail
     *
     * @return Response
     */
    public function postEmail($user=false)
    {

		$title = Lang::get('core.email');

		if(is_array(Input::get('to')) && count(Input::get('to')) >0){
			$_results=false;
			foreach (Input::get('to') as $user_id){
				$user=User::find($user_id);
				if(!empty($user)) {
					$_results=$this->sendEmail($user, Input::get('template'));
				} else $_results=false;
			}
			if($_results == true){
				$message=Lang::get('admin/users/messages.email.success');
				return Theme::make('admin/users/email_results', compact('title', 'message', '_results'));
			} else {
				$message=Lang::get('admin/users/messages.email.error');
				return Theme::make('admin/users/email_results', compact('title', 'message', '_results'));
			}
		} elseif (isset($user))
        {
			if($this->sendEmail($user, Input::get('template'))) {
				return Api::to(array('success', Lang::get('admin/users/messages.email.success'))) ? : Redirect::to('admin/users/' . $user->id . '/email')->with('success', Lang::get('admin/users/messages.email.success'));
			} else return Api::to(array('error', Lang::get('admin/users/messages.email.error'))) ? : Redirect::to('admin/users/' . $user->id . '/email')->with('error', Lang::get('admin/users/messages.email.error'));
		} else {
			$message=Lang::get('admin/users/messages.email.error');
			Theme::make('admin/users/email_results', compact('title', 'message'));
		}
    }


    /**
     * get mass mail
     *
     * @return Response
     */
	public function getEmailMass($a=false){
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$multi=array();


		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=User::find($id);
				if(!empty($user)) $multi[$id]=$user->email;
			}
		
		}

		$title = Lang::get('core.mass_email');

		$mode = 'edit';
		$templates=$this->emailTemplates();
		return Theme::make('admin/users/send_email', compact('title', 'mode', 'multi', 'templates'));
	}


    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        
		$users = User::leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
                    ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
                    ->select(DB::raw('users.id, users.displayname,users.email, group_concat(roles.name SEPARATOR \', \') as rolename'))->groupBy(DB::raw('users.id , users.displayname , users.email'));

		if(Api::Enabled()){
			$u=$users->get();
			return Api::make($u->toArray());
		} else return Datatables::of($users)
        ->add_column('actions', '<div class="btn-group">
		<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-sm btn-primary">{{{ Lang::get(\'button.edit\') }}}</a> 
		<a href="{{{ URL::to(\'admin/users/\' . $id . \'/email\' ) }}}" class="modalfy btn btn-sm btn-default">{{{ Lang::get(\'button.email\') }}}</a>
		@if($id == Auth::user()->id)
			<a href="#" class="disabled btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
		@else
			<a data-row="{{{  $id }}}" data-table="users" data-method="delete" href="{{{ URL::to(\'admin/users/\' . $id . \'\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
		@endif</div>
            ')

        ->make();
    }
}
