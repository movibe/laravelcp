<?php 
use Gcphost\LaravelCP\Role\RoleRepository as Role;

class RoleService {
    protected $user;
    protected $role;
    protected $permission;

    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

	public function index()
    {
        $roles = $this->role;
        return Theme::make('admin/roles/index', compact('roles'));
    }

    public function getCreate()
    {
        $permissions = $this->permission->all();
        $selectedPermissions = Input::old('permissions', array());
        return Theme::make('admin/roles/create_edit', compact('permissions', 'selectedPermissions'));
    }

    public function create()
    {
		$inputs = Input::except('csrf_token');
		if(in_array(Input::get('name'), \Role::$protected))return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->with('error', Lang::get('admin/roles/messages.create.error'));
		
		$save=$this->role->createOrUpdate(null, $this->permission->preparePermissionsForSave($inputs['permissions']));
		$errors = $save->errors();

		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/roles/messages.create.success') )) ? : Redirect::to('admin/roles/' . $this->role->id . '/edit')->with('success', Lang::get('admin/roles/messages.create.success'))) : 
			(Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->withInput()->withErrors($errors));
    }

    public function getEdit($role)
    {
        if(!empty($role))
        {
            $permissions = $this->permission->preparePermissionsForDisplay($role->perms()->get());
        }
        else return Api::to(array('error', Lang::get('admin/roles/messages.does_not_exist'))) ? : Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.does_not_exist'));
        
        return Theme::make('admin/roles/create_edit', compact('role', 'permissions'));
    }

    public function edit($role)
    {
		if((in_array(Input::old('name', $role->name), \Role::$protected) &&Input::old('name', $role->name) != Input::get('name'))||( in_array(Input::get('name'), \Role::$protected)  && Input::old('name', $role->name) != Input::get('name'))) 
			return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', Lang::get('admin/roles/messages.update.error'));

		$inputs = Input::except('csrf_token');
		$save=$this->role->createOrUpdate($role->id, $this->permission->preparePermissionsForSave($inputs['permissions']));
		$errors = $save->errors();

		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/roles/messages.update.success'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('success', Lang::get('admin/roles/messages.update.success'))) :
			(Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->withErrors($errors));
    }

    public function delete($role)
    {
		if(in_array($role->name, \Role::$protected)){
			return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		} else return $role->delete() ? 
			Api::json(array('result'=>'success')) : 
			Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    }

	public function page($limit=10){
		return $this->role->paginate($limit);
	}

	public function get()
    {
		if(Api::Enabled()){
			return Api::make($this->role->all()->get()->toArray());
		} else return Datatables::of($this->role->all())
		->edit_column('name', '<a href="{{{ URL::to(\'admin/roles/\' . $id . \'/edit\' ) }}}" class="modalfy">{{{$name}}}</a>')

        ->edit_column('users', '{{{ DB::table(\'assigned_roles\')->where(\'role_id\', \'=\', $id)->count()  }}}')
        ->add_column('actions', '
			 <div class="btn-group btn-hover">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					  <span class="fa fa-lg fa-cog fa-fw"></span>
					  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="{{{ URL::to(\'admin/roles/\' . $id . \'/edit\' ) }}}" class="modalfy">{{{ Lang::get(\'button.edit\') }}}</a></li>
					<li class="divider"></li>
					@if(in_array($name, Role::$protected) || $id == Setting::get("users.default_role_id"))
						<li><a href="#disabled" class="disabled">{{{ Lang::get(\'button.delete\') }}}</a></li>
					@else
						<li><a data-row="{{{  $id }}}" data-method="delete" data-table="roles" href="{{{ URL::to(\'admin/roles/\' . $id . \'\' ) }}}" class="confirm-ajax-update">{{{ Lang::get(\'button.delete\') }}}</a></li>
					@endif 
				</ul>
			</div>
         ')
        ->make();
    }
}