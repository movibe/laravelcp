<?php 
use Gcphost\LaravelCP\User\UserRepository as User;

class UserService {
    protected $user;
    protected $role;
    protected $permission;
    protected $validator;

    function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }
 
    public function create()
    {
		$save=$this->user->createOrUpdate();
		$errors=$save->errors();
		Event::fire('controller.user.create', array($this->user));
		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/users/messages.edit.success'))) ? : Redirect::to('admin/users/' . $this->user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'))) :
			(Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? : Redirect::to('admin/users/create')->withErrors($errors));
	}

    public function edit($user)
    {
		$save=$this->user->createOrUpdate($user->id);
		$errors=$save->errors();
		Event::fire('controller.user.edit', array($user));
		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/users/messages.edit.success'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'))) :
			(Api::to(array('error', Lang::get('admin/users/messages.edit.error'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($errors));
    }


    public function listusers()
    {
		return Api::json($this->user->clients(Input::get('q'),Input::get('page_limit'), Input::get('page'), Input::get('id'))->toArray());
	}

    public function listadmins()
    {
		return Api::json($this->user->clients(Input::get('q'),Input::get('page_limit'), Input::get('page'), Input::get('id'), true)->toArray());
	}

	 public function activity($user){
        if ( $user->id )
        {
			$list = $user->activity();
			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')->make();
		}
	 }

    public function notes($user)
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

	public function resetpassword($user){
		if(!Confide::forgotPassword( $user->email)){
			if(!Api::make(array('error'))) return Response::json(array('result'=>'error'));
		} else if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
	}

    public function deletemass()
    {
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			foreach($rows as $i=>$r) LaravelCP::runDeleteMass($r);
		}elseif(is_integer($rows)) LaravelCP::runDeleteMass($rows);
		if(!Api::make(array('success'))) return Response::json(array('result'=>'success'));
	}

    public function delete($user)
    {
        return $user->delete() ? 
			Api::json(array('result'=>'success')) :
			Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    } 
	
	public function switchuser($user)
    {
		Auth::login($user);
		return Redirect::to('/');
	}

    public function index()
    {
        $users = $this->user;
		$users->chart();
       	return Theme::make('admin/users/index', compact('users'));
    }

    public function getCreate()
    {
		$roles = $this->role->lists('name', 'id');
        $permissions = $this->permission->all();
        $selectedRoles = Input::old('roles', array());
        $selectedPermissions = Input::old('permissions', array());
		$mode = 'create';
		return Theme::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'mode'));
    }

	public function getEdit($user)
    {
        if ( $user->id )
        {
			$roles = $this->role->lists('name', 'id');
			$profiles=$user->profiles;
			$last_login = $user->lastlogin();

            $permissions = $this->permission->all();
        	$mode = 'edit';

			return Theme::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'mode', 'profiles', 'last_login'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

	public function page($limit=10){
		return $this->user->paginate($limit);
	}
	
	public function get()
    {
   		if(Api::Enabled()){
			return Api::make($this->user->all()->get()->toArray());
		} else return Datatables::of($this->user->all())
		->edit_column('displayname', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="modalfy">{{{$displayname}}}</a>')
		->edit_column('email', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/email\' ) }}}" class="modalfy">{{{$email}}}</a>')
        ->add_column('actions', '
			 <div class="btn-group btn-hover">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					  <span class="fa fa-lg fa-cog fa-fw"></span>
					  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="modalfy">{{{ Lang::get(\'button.edit\') }}}</a></li>
					<li class="divider"></li>
					<li><a href="{{{ URL::to(\'admin/users/\' . $id . \'/email\' ) }}}" class="modalfy">{{{ Lang::get(\'button.email\') }}}</a></li>
					<li class="divider"></li>
					@if($id == Auth::user()->id)
						<li><a href="#disabled" class="disabled">{{{ Lang::get(\'button.delete\') }}}</a></li>
					@else
						<li><a data-row="{{{  $id }}}" data-table="users" data-method="delete" href="{{{ URL::to(\'admin/users/\' . $id . \'\' ) }}}" class="confirm-ajax-update">{{{ Lang::get(\'button.delete\') }}}</a></li>
					@endif
				</ul>
			</div>
            ')
        ->make();
    }
}