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


	private function userChart(){
		$chart = Lava::DataTable('activeusers');
		$chart->addColumn('string', 'Active', 'active');
		$chart->addColumn('string', 'Inactive', 'inactive');

		$chart->addRow(array('Active',DB::table('users')->where('confirmed', '=', '1')->count()));
		$chart->addRow(array('In-active',DB::table('users')->where('confirmed', '!=', '1')->count()));

		Lava::PieChart('activeusers')->addOption(array('chartArea' => array('width'=>'98%', 'height'=>'98%')))->addOption(array('backgroundColor' => 'none'))->addOption(array('is3D' => 'true'))->addOption(array('legend' => 'none'));
	}



    public function getIndex()
    {
        $title = Lang::get('admin/users/title.user_management');

        $users = $this->user;


		$this->userChart();

       	if(!Api::View(compact('users', 'title'))) return View::make('admin/users/index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        // All roles
        $roles = $this->role->all();

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected groups
        $selectedRoles = Input::old('roles', array());

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

		// Title
		$title = Lang::get('admin/users/title.create_a_new_user');

		// Mode
		$mode = 'create';

		// Show the page
		if(!Api::View(compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'))) return View::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
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

			if ( $this->user->id )
			{
				$this->user->saveRoles(Input::get( 'roles' ));

				$pro=Input::get('user_profiles');
				$profile = new UserProfile($pro['new']);
				$user = User::find($this->user->id);
				$user->profiles()->save($profile);

				if(!Api::Redirect(array('success', Lang::get('admin/users/messages.create.success')))) return Redirect::to('admin/users/' . $this->user->id . '/edit')->with('success', Lang::get('admin/users/messages.create.success'));
			}
			else
			{
				$error = $this->user->errors()->all();
				if(!Api::Redirect(array( 'error', $error ))) return Redirect::to('admin/users/create')->withInput(Input::except('password'))->with( 'error', $error );
			}
        } else {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.edit.error')))) return Redirect::to('admin/users/create')->withInput(Input::except('password'))->with('error', Lang::get('admin/users/messages.edit.error'))->withErrors($validator);
        }
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
				return Api::View($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->make();
		}
	 }

	 public function getEmails($user){
        if ( $user->id )
        {
			$list = Activity::whereRaw('user_id = ? AND content_type="email"', array($user->id))->select(array('user_id','description', 'details','ip_address', 'updated_at'))->orderBy('id', 'DESC');

			if(Api::Enabled()){
				$u=$list->get();
				return Api::View($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->edit_column('details','{{{ strip_tags(substr($details,0,100))}}}')
				->make();
		}
	 }

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

			if(!Api::View(compact('user', 'roles', 'permissions', 'title', 'mode', 'profiles', 'last_login'))) return View::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode', 'profiles', 'last_login'));
        }
        else
        {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.does_not_exist')))) return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
        }
    }




    public function deleteNotes($user, $note)
    {


	}

    public function getNotes($user)
    {

        if ( $user->id )
        {
			$list = UserNotes::leftjoin('users', 'users.id', '=', 'user_notes.admin_id')
					->select(array('user_notes.id', 'user_notes.note', 'user_notes.created_at', 'user_notes.updated_at', 'users.displayname'))->where('user_notes.user_id','=',$user->id)->orderBy('users.id');
			if(Api::Enabled()){
				$u=$list->get();
				return Api::View($u->toArray());
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
		
		if(!empty(Input::get( 'password' ))) {
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
            

            if(!empty(Input::get( 'password' ))) {
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
				if($pro){
					$pro->fill($profile)->push();
				} else {
					$pro = new UserProfile($profile);
					if($pro->title) $user->profiles()->save($pro);
				}
			}

			foreach(Input::get('user_notes') as $id=>$note){
				$not = UserNotes::find($id);
				if($not){
					if($note){
						$not->fill(array('id'=>$id,'note'=>$note))->push();
					} else $not->delete();
				} else {
					$not = new UserNotes(array('id'=>$id,'note'=>$note, 'admin_id' =>Confide::user()->id));
					if($not->note) $user->notes()->save($not);
				}
			}

        } else {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.edit.error')))) return Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($validator);
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            // Redirect to the new user page
            if(!Api::Redirect(array('success', Lang::get('admin/users/messages.edit.success')))) return Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'));
        } else {
           if(!Api::Redirect(array('error', Lang::get('admin/users/messages.edit.error'))))  return Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.edit.error'));
        }
    }

   



	private function runMerge($_merge_to, $user){
		DB::update('UPDATE user_profiles set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE posts set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE comments set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::update('UPDATE activity_log set user_id = ? where user_id = ?', array($_merge_to->id, $user->id));
		DB::table('assigned_roles')->where('user_id', '=', $user->id)->delete();
		$user->delete();
	}


    public function postMerge()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			if(count($rows) < 2) if(!Api::Redirect(array('error',Lang::get('core.mergeerror')))) return Response::json(array('result'=>'error', 'error' =>  Lang::get('core.mergeerror')));
			$_merge_to=false;
			foreach($rows as $i=>$r){
				if ($r != Confide::user()->id){
					$user = User::find($r);
					try {
						if(!$_merge_to){
							$_merge_to=$user;
							continue;
						}
						$this->runMerge($_merge_to, $user);
					} catch (Exception $e) {
						if(!Api::Redirect(array('error', $e->getMessage()))) return Response::json(array('result'=>'error', 'error' =>  $e->getMessage()));
					}
				}
			}
		}
		if(!Api::View(array('success'))) return Response::json(array('result'=>'success'));
    }

	private function runDeleteMass($r){
		if ($r != Confide::user()->id){
			$user = User::find($r);
			try {
				$user->delete();
			} catch (Exception $e) {
				if(!Api::Redirect(array('error', $e->getMessage()))) return Response::json(array('result'=>'error', 'error' =>  $e->getMessage()));
			}
		}

	}


    public function getMassMergeConfirm()
    {
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$mergefrom='';
		$mergelist=array();

		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=User::find($id);
				if($mergefrom){
					$mergelist[$id]=$user->email;
				}else $mergefrom=$user->email;
			}
		
		}

        if(!Api::View(compact('mergelist', 'mergefrom'))) return View::make('admin/users/confirm_merge', compact('mergelist','mergefrom'));
    }

    public function postDeleteMass()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			foreach($rows as $i=>$r) $this->runDeleteMass($r);
		}elseif(is_integer($rows))$this->runDeleteMass($rows);
		if(!Api::View(array('success'))) return Response::json(array('result'=>'success'));
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
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.delete.impossible')))) return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

		$id=$user->id;

		try {
			$user->delete();
		} catch (Exception $e) {
			if(!Api::Redirect(array('error',  $e->getMessage()))) return Response::json(array('result'=>'error', 'error' =>  $e->getMessage()));
		}

        // Was the comment post deleted?
        $user = User::find($id);
        if (empty($user)){
			if(!Api::Redirect(array('success'))) return Response::json(array('result'=>'success'));
        } else  if(!Api::Redirect(array('error', $e->getMessage()))) return Response::json(array('result'=>'error', 'error' =>  $e->getMessage()));
        
    }

	private function emailTemplates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR."emails");
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
        	if(!Api::View(compact('user', 'title', 'mode', 'templates'))) return View::make('admin/users/send_email', compact('user', 'title', 'mode', 'templates'));
        }
        else
        {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.does_not_exist')))) return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
        }
    }

    
	private function sendEmail($user, $template='emails.default'){
		if (!View::exists($template))$template='emails.default';

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



    public function postEmail($user=false)
    {

		$title = Lang::get('core.email');

		if(is_array(Input::get('to')) && count(Input::get('to')) >0){
			$_results=false;
			foreach (Input::get('to') as $user_id){
				$user=User::find($user_id);
				$_results=$this->sendEmail($user, Input::get('template'));
			}
			if($_results == true){
				$message=Lang::get('admin/users/messages.email.success');
				if(!Api::View(compact('title', 'message', '_results'))) return View::make('admin/users/email_results', compact('title', 'message', '_results'));
			} else {
				$message=Lang::get('admin/users/messages.email.error');
				if(!Api::View(compact('title', 'message', '_results'))) return View::make('admin/users/email_results', compact('title', 'message', '_results'));
			}
		} elseif (isset($user))
        {
			if($this->sendEmail($user, Input::get('template'))) {
				if(!Api::Redirect(array('success', Lang::get('admin/users/messages.email.success')))) return Redirect::to('admin/users/' . $user->id . '/email')->with('success', Lang::get('admin/users/messages.email.success'));
			} else if(!Api::Redirect(array('error', Lang::get('admin/users/messages.email.error')))) return Redirect::to('admin/users/' . $user->id . '/email')->with('error', Lang::get('admin/users/messages.email.error'));
		} else {
			$message=Lang::get('admin/users/messages.email.error');
			if(!Api::View(compact('title', 'message'))) return View::make('admin/users/email_results', compact('title', 'message'));
		}
    }




	public function getEmailMass($a=false){
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$multi=array();


		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=User::find($id);
				$multi[$id]=$user->email;
			}
		
		}

		$title = Lang::get('core.mass_email');

		$mode = 'edit';
		$templates=$this->emailTemplates();
		if(!Api::View(compact('title', 'mode', 'multi', 'templates')))return View::make('admin/users/send_email', compact('title', 'mode', 'multi', 'templates'));
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
                    ->select(DB::raw('users.id, users.displayname,users.email, group_concat(roles.name SEPARATOR \', \') as rolename'))->groupBy(DB::raw('users.id , users.displayname , users.email'))->orderBy('users.id');

		if(Api::Enabled()){
			$u=$users->get();
			return $u->toArray();
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
