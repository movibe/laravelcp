<?php
use Illuminate\Filesystem\Filesystem;
use Gcphost\Helpers\User\UserRepository as User;

class AdminUsersController extends AdminController {

    protected $user;
    protected $role;
    protected $permission;


    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;

    }

    public function getList()
    {
		return Api::json($this->user->clients(Input::get('q'),Input::get('page_limit'), Input::get('page'), Input::get('id'))->toArray());
	}

    public function getListadmin()
    {
		return Api::json($this->user->clients(Input::get('q'),Input::get('page_limit'), Input::get('page'), Input::get('id'), true)->toArray());
	}


    public function getIndex()
    {
        $users = $this->user;
		LCP::userChart();
        $title = Lang::get('admin/users/title.user_management');
       	return Theme::make('admin/users/index', compact('users', 'title'));
    }

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
			if ( $this->user->createOrUpdate() )
			{
				Event::fire('controller.user.create', array($this->user));
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


	public function postResetpassword($user){
		if(!Confide::forgotPassword( $user->email)){
			if(!Api::make(array('error'))) return Response::json(array('result'=>'error'));
		} else if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
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

			return Theme::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode', 'profiles', 'last_login'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

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
			if ( $this->user->createOrUpdate($user->id) )
			{
				Event::fire('controller.user.edit', array($user));

				return Api::to(array('success', Lang::get('admin/users/messages.edit.success'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'));
			}
        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? :  Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($validator);
        

        $error = $user->errors()->all();

        if(empty($error)) {
           return Api::to(array('success', Lang::get('admin/users/messages.edit.success'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.edit.error'));
    }



    public function postMerge()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			if(count($rows) < 2) return Api::to(array('error',Lang::get('core.mergeerror'))) ? : Response::json(array('result'=>'error', 'error' =>  Lang::get('core.mergeerror')));
			$_merge_to=false;
			foreach($rows as $i=>$r){
				if ($r != Confide::user()->id){
					$user = $this->user->find($r);
					if(!empty($user)){
						if(!$_merge_to){
							$_merge_to=$user;
							continue;
						}
						LCP::merge($_merge_to, $user);
					} else  return Api::to(array('error', '')) ? : Response::json(array('result'=>'error', 'error' =>  ''));
				}
			}
		}
		if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
    }


    public function getMassMergeConfirm()
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

 
    public function postDeleteMass()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			foreach($rows as $i=>$r) LCP::runDeleteMass($r);
		}elseif(is_integer($rows)) LCP::runDeleteMass($rows);
		if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
	}


    public function deleteIndex($user)
    {
        if ($user->id === Confide::user()->id)
        {
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
		$user=$this->user->find($id);
        return empty($user) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
        
    }


    public function getData()
    {
   		if(Api::Enabled()){
			return Api::make($this->user->all()->get()->toArray());
		} else return Datatables::of($this->user->all())
        ->add_column('actions', '<div class="btn-group">
		<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-sm btn-primary">{{{ Lang::get(\'button.edit\') }}}</a> 
		<a href="{{{ URL::to(\'admin/users/\' . $id . \'/email\' ) }}}" class="modalfy btn btn-sm btn-default">{{{ Lang::get(\'button.email\') }}}</a>
		@if($id == Auth::user()->id)
			<a href="#" class="disabled btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
		@else
			<a data-row="{{{  $id }}}" data-table="users" data-method="delete" href="{{{ URL::to(\'admin/users/\' . $id . \'\' ) }}}" class="confirm-ajax-update btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
		@endif</div>
            ')

        ->make();
    }
}
