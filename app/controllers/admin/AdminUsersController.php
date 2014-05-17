<?php
use Gcphost\Helpers\User\UserRepository as User;

class AdminUsersController extends BaseController {

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
		$users->chart();
       	return Theme::make('admin/users/index', compact('users'));
    }

    public function getCreate()
    {
        $roles = $this->role->all();
        $permissions = $this->permission->all();
        $selectedRoles = Input::old('roles', array());
        $selectedPermissions = Input::old('permissions', array());
		$mode = 'create';
		return Theme::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'mode'));
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
			return $this->user->createOrUpdate() ?
				Api::to(array('success', Lang::get('admin/users/messages.create.success'))) ? : Redirect::to('admin/users/' . $this->user->id . '/edit')->with('success', Lang::get('admin/users/messages.create.success')) :
				Api::to(array('error', $this->user->errors()->all() )) ? :  Redirect::to('admin/users/create')->withInput(Input::except('password'))->with( 'error', $this->user->errors()->all() );
        } else return Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? :  Redirect::to('admin/users/create')->withInput(Input::except('password'))->with('error', Lang::get('admin/users/messages.edit.error'))->withErrors($validator);
    }

	 public function getActivity($user){
        if ( $user->id )
        {
			$list = $user->activity();
			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')->make();
		}
	 }

    public function getNotes($user)
    {
        if ( $user->id )
        {
			$list = $user->getnotes();
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
			$last_login = $user->lastlogin();

            $permissions = $this->permission->all();
        	$mode = 'edit';

			return Theme::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'mode', 'profiles', 'last_login'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
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
        
        return $user->delete() ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
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
