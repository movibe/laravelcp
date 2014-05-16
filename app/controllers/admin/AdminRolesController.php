<?php

class AdminRolesController extends AdminController {
    protected $user;
    protected $role;
    protected $permission;
	private $protected_roles=array('admin','client');

    public function __construct(User $user, Role $role, Permission $permission)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

	public function getIndex()
    {
        $roles = $this->role;
        return Theme::make('admin/roles/index', compact('roles'));
    }

    public function getCreate()
    {
        $permissions = $this->permission->all();
        $selectedPermissions = Input::old('permissions', array());
        return Theme::make('admin/roles/create', compact('permissions', 'selectedPermissions'));
    }

    public function postCreate()
    {

        $rules = array(
            'name' => 'required'
        );


		$validator = Validator::make(Input::all(), $rules);
        if ($validator->passes())
        {

			if(in_array(Input::get('name'), $this->protected_roles)) 
				return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->with('error', Lang::get('admin/roles/messages.create.error'));

            $inputs = Input::except('csrf_token');

            $this->role->name = $inputs['name'];
            $this->role->save();

            $this->role->perms()->sync($this->permission->preparePermissionsForSave($inputs['permissions']));

            if ($this->role->id)
            {
                return Api::to(array('success', Lang::get('admin/roles/messages.create.success') )) ? : Redirect::to('admin/roles/' . $this->role->id . '/edit')->with('success', Lang::get('admin/roles/messages.create.success'));
            } else return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->withInput()->with('error', Lang::get('admin/roles/messages.create.error'));
        } else return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->withInput()->withErrors($validator);
    }



    public function getEdit($role)
    {
        if(!empty($role))
        {
            $permissions = $this->permission->preparePermissionsForDisplay($role->perms()->get());
        }
        else return Api::to(array('error', Lang::get('admin/roles/messages.does_not_exist'))) ? : Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.does_not_exist'));
        
        return Theme::make('admin/roles/edit', compact('role', 'permissions'));
    }

    public function putEdit($role)
    {
        $rules = array(
            'name' => 'required'
        );

		if((in_array(Input::old('name', $role->name), $this->protected_roles) &&Input::old('name', $role->name) != Input::get('name'))||( in_array(Input::get('name'), $this->protected_roles)  && Input::old('name', $role->name) != Input::get('name'))) 
			return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', Lang::get('admin/roles/messages.update.error'));

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes())
        {
            $role->name        = Input::get('name');
            $role->perms()->sync($this->permission->preparePermissionsForSave(Input::get('permissions')));

            if ($role->save())
            {
                return Api::to(array('success', Lang::get('admin/roles/messages.update.success'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('success', Lang::get('admin/roles/messages.update.success'));
            }
            else return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', Lang::get('admin/roles/messages.update.error'));
        }
        return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->withInput()->withErrors($validator);
    }



    public function deleteIndex($role)
    {
		$id=$role->id;
		if(!$role->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$roles=Roles::find($id);
        return empty($roles) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    }

    public function getData()
    {
        $roles = Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at'));

        if(Api::Enabled()){
			$u=$roles->get();
			return Api::make($u->toArray());
		} else return Datatables::of($roles)
        ->edit_column('users', '{{{ DB::table(\'assigned_roles\')->where(\'role_id\', \'=\', $id)->count()  }}}')


        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/roles/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-sm btn-primary">{{{ Lang::get(\'button.edit\') }}}</a>
                                <a data-row="{{{  $id }}}" data-method="delete" data-table="roles" href="{{{ URL::to(\'admin/roles/\' . $id . \'\' ) }}}" class="confirm-ajax-update btn btn-sm btn-danger" @if($name == "admin" || $name == "users")disabled@endif>{{{ Lang::get(\'button.delete\') }}}</a></div>
                    ')


        ->make();
    }

}