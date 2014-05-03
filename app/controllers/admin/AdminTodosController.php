<?php
use Illuminate\Filesystem\Filesystem;

class AdminTodosController extends AdminController {

    protected $todo;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Todos $todo)
    {
        parent::__construct();
        $this->todo = $todo;
    }

    /**
     * get index
     *
     * @return Response
     */
	public function getIndex(){
		return Theme::make('admin/todos/index');
	}

    /**
     * get create
     *
     * @return Response
     */
	public function getCreate()
	{
        $title = Lang::get('admin/todos/title.create_a_new');
        return Theme::make('admin/todos/create_edit', compact('title'));
	}

    /**
     * post create
     *
     * @return Response
     */
	public function postCreate(){
		$rules = array(
			'title' => 'required',
		);

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
            $this->todo->title            = Input::get('title');
            $this->todo->description            = Input::get('description');
            $this->todo->status            = Input::get('status');
            $this->todo->due_at		  = Carbon::parse(Input::get('due_at'));

            return $this->todo->save() ?
				Api::to(array('success', Lang::get('admin/todos/messages.create.success'))) ? : Redirect::to('admin/todos/' . $this->todo->id . '/edit')->with('success', Lang::get('admin/todos/messages.create.success')) : 
				Api::to(array('error', Lang::get('admin/todos/messages.create.error'))) ? : Redirect::to('admin/todos/create')->with('error', Lang::get('admin/todos/messages.create.error'));
        } else return Api::to(array('error', Lang::get('admin/todos/messages.create.error'))) ? : Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($validator);
	}

    /**
     * get edit
     *
     * @return Response
     */
	public function getEdit($todo)
	{
        $title = Lang::get('admin/todos/title.update');
        return Theme::make('admin/todos/create_edit', compact('todo', 'title'));
	}


    /**
     * put edit
     *
     * @return Response
     */
	public function putEdit($todo){
		$rules = array(
			'title' => 'required',
		);

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
            $todo->title            = Input::get('title');
            $todo->description      = Input::get('description');
            $todo->status		  = Input::get('status');
            $todo->due_at		  = Carbon::parse(Input::get('due_at'));

             return $todo->save() ?
				Api::to(array('success', Lang::get('admin/todos/messages.create.success'))) ? : Redirect::to('admin/todos/' . $todo->id . '/edit')->with('success', Lang::get('admin/todos/messages.create.success')) : 
				Api::to(array('error', Lang::get('admin/todos/messages.create.error'))) ? : Redirect::to('admin/todos/' . $todo->id . '/edit')->with('error', Lang::get('admin/todos/messages.create.error'));
        } else return Api::to(array('error', Lang::get('admin/todos/messages.create.error'))) ? : Redirect::to('admin/todos/' . $todo->id . '/edit')->withErrors($validator);
	}

    /**
     * delete
     *
     * @return Response
     */
    public function deleteIndex($todo)
    {
		$id = $todo->id;
		if(!$todo->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$todos=Todos::find($id);
        return empty($todos) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    }

    /**
     * assign to current user
     *
     * @return Response
     */
	public function postAssign($todo){
		$todo->admin_id=Confide::user()->id;
        return $todo->save() ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
	}

    /**
     * get data
     *
     * @return Response
     */
     public function getData()
    {
		$list = Todos::leftjoin('users', 'users.id', '=', 'todos.admin_id')
				->select(array('todos.id', 'todos.title', 'todos.status', 'todos.description', 'todos.created_at', 'todos.due_at', 'users.displayname'));
		if(Api::Enabled()){
			$u=$list->get();
			return Api::make($u->toArray());
		} else return Datatables::of($list)
			 ->edit_column('status','{{{ Lang::get(\'admin/todos/todos.status_\'.$status) }}}')
			 ->edit_column('due_at','{{{ Carbon::parse($due_at)->diffForHumans() }}}')
			 ->edit_column('created_at','{{{ Carbon::parse($created_at)->diffForHumans() }}}')
			 ->edit_column('displayname','{{{ $displayname ? : "Nobody" }}}')
	        ->add_column('actions', '<div class="btn-group" style="width: 200px">
		<a href="{{{ URL::to(\'admin/todos/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-sm btn-primary">{{{ Lang::get(\'button.edit\') }}}</a> 
		<a href="{{{ URL::to(\'admin/todos/\' . $id . \'/assign\' ) }}}" data-row="{{{  $id }}}" data-table="todos" class="ajax-alert-confirm btn btn-sm btn-default">{{{ Lang::get(\'button.assign_to_me\') }}}</a>
			<a data-row="{{{  $id }}}" data-table="todos" data-method="delete" href="{{{ URL::to(\'admin/todos/\' . $id . \'\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
		</div>
            ')
			->make();
	}
}
?>