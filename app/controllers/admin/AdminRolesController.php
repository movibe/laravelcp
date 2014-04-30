<?php

class AdminRolesController extends AdminController {


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

    /**
     * Protected Roles
     */
	private $protected_roles=array('admin','client');


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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $roles = $this->role;
        $title = Lang::get('admin/roles/title.role_management');
        return Theme::make('admin/roles/index', compact('roles', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $permissions = $this->permission->all();
        $selectedPermissions = Input::old('permissions', array());
        $title = Lang::get('admin/roles/title.create_a_new_role');
        return Theme::make('admin/roles/create', compact('permissions', 'selectedPermissions', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
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

			// Get the inputs, with some exceptions
            $inputs = Input::except('csrf_token');

            $this->role->name = $inputs['name'];
            $this->role->save();

            // Save permissions
            $this->role->perms()->sync($this->permission->preparePermissionsForSave($inputs['permissions']));

            // Was the role created?
            if ($this->role->id)
            {
                return Api::to(array('success', Lang::get('admin/roles/messages.create.success') )) ? : Redirect::to('admin/roles/' . $this->role->id . '/edit')->with('success', Lang::get('admin/roles/messages.create.success'));
            } else return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->withInput()->with('error', Lang::get('admin/roles/messages.create.error'));
        } else return Api::to(array('error', Lang::get('admin/roles/messages.create.error'))) ? : Redirect::to('admin/roles/create')->withInput()->withErrors($validator);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param $role
     * @return Response
     */
    public function getEdit($role)
    {
        if(!empty($role))
        {
            $permissions = $this->permission->preparePermissionsForDisplay($role->perms()->get());
        }
        else return Api::to(array('error', Lang::get('admin/roles/messages.does_not_exist'))) ? : Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.does_not_exist'));
        
        $title = Lang::get('admin/roles/title.role_update');
        return Theme::make('admin/roles/edit', compact('role', 'permissions', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $role
     * @return Response
     */
    public function putEdit($role)
    {
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required'
        );

		if((in_array(Input::old('name', $role->name), $this->protected_roles) &&Input::old('name', $role->name) != Input::get('name'))||( in_array(Input::get('name'), $this->protected_roles)  && Input::old('name', $role->name) != Input::get('name'))) 
			return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', Lang::get('admin/roles/messages.update.error'));

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
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

        // Form validation failed
        return Api::to(array('error', Lang::get('admin/roles/messages.update.error'))) ? : Redirect::to('admin/roles/' . $role->id . '/edit')->withInput()->withErrors($validator);
    }



    /**
     * Remove the specified user from storage.
     *
     * @param $role
     * @internal param $id
     * @return Response
     */
    public function deleteIndex($role)
    {
		$id=$role->id;
		if(!$role->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$roles=Roles::find($id);
        return empty($roles) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    }

    /**
     * Show a list of all the roles formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $roles = Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at'));

        if(Api::Enabled()){
			$u=$roles->get();
			return Api::make($u->toArray());
		} else return Datatables::of($roles)
        // ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')
        ->edit_column('users', '{{{ DB::table(\'assigned_roles\')->where(\'role_id\', \'=\', $id)->count()  }}}')


        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/roles/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-sm btn-primary">{{{ Lang::get(\'button.edit\') }}}</a>
                                <a data-row="{{{  $id }}}" data-method="delete" data-table="roles" href="{{{ URL::to(\'admin/roles/\' . $id . \'\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger" @if($name == "admin" || $name == "users")disabled@endif>{{{ Lang::get(\'button.delete\') }}}</a></div>
                    ')


        ->make();
    }

}