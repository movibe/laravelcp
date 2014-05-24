<?php namespace Gcphost\LaravelCP\Todo;

use Carbon,Input, Todos,DB;

class EloquentTodoRepository implements TodoRepository
{
	public $modelClassName="Todo";
	public $id;

	public function __construct(Todos $todo)
    {
        $this->todo = $todo;
    }

	public function createOrUpdate($id = null)
    {
        if(is_null($id))
		{
            $todo = new Todos;
        } else $todo = Todos::find($id);

		$todo->title            = Input::get('title');
		$todo->description      = Input::get('description');
		$todo->status           = Input::get('status');
		$todo->due_at		    = Carbon::parse(Input::get('due_at'));
		$todo->save();
		if ( $todo->id ) $this->id=$todo->id;

		return $todo;
    }



	public function all(){
		return Todos::leftjoin('users', 'users.id', '=', 'todos.admin_id')
				->select(array('todos.id', 'todos.title', 'todos.status', 'todos.description', 'todos.created_at', 'todos.due_at', 'users.displayname'));
	}

	public function find($id, $columns = array('*'))
	{
		return Todos::find($id);
	}
	
	public function delete($id)
	{
		return Todos::delete($id);
	}

	public function __call($method, $args)
    {
        return call_user_func_array([$this->todo, $method], $args);
    }

}