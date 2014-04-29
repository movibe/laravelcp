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

	
	public function getIndex(){
		
		return Theme::make('admin/todos/index');

	}

	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/todos/title.create_a_new');

        // Show the page
        return Theme::make('admin/todos/create_edit', compact('title'));
	}

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

            if($this->todo->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/todos/' . $this->todo->id . '/edit')->with('success', Lang::get('admin/todos/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/todos/create')->with('error', Lang::get('admin/todos/messages.create.error'));


        } else {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.edit.error')))) return Redirect::to('admin/users/' . $user->id . '/edit')->withErrors($validator);
        }

	}

	public function getEdit($todo)
	{
        // Title
        $title = Lang::get('admin/todos/title.update');

		// Show the page
        return Theme::make('admin/todos/create_edit', compact('todo', 'title'));
	}


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

            if($todo->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/todos/' . $todo->id . '/edit')->with('success', Lang::get('admin/todos/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/todos/' . $todo->id . '/edit')->with('error', Lang::get('admin/todos/messages.update.error'));


        } else {
            if(!Api::Redirect(array('error', Lang::get('admin/users/messages.edit.error')))) return Redirect::to('admin/todos/' . $todo->id . '/edit')->withErrors($validator);
        }
	}

    public function deleteIndex($todo)
    {
		$id = $todo->id;
		$todo->delete();

		$todo = Todos::find($id);
		if(empty($todo)){
		  return Response::json(array('result'=>'success'));
		} else return Response::json(array('result'=>'error', 'error' =>Lang::get('admin/todos/messages.delete.error')));

    }

	public function postAssign($todo){
		$todo->admin_id=Confide::user()->id;
		$todo->save();
		return Response::json(array('result'=>'success'));
	}

     public function getData()
    {
		$list = Todos::leftjoin('users', 'users.id', '=', 'todos.admin_id')
				->select(array('todos.id', 'todos.title', 'todos.status', 'todos.description', 'todos.created_at', 'todos.due_at', 'users.displayname'))->orderBy('todos.id');
		if(Api::Enabled()){
			$u=$list->get();
			return Api::View($u->toArray());
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