<?php
class AdminTodosController extends BaseController {
    protected $service;

    public function __construct(TodosService $service)
    {
        $this->service = $service;
    }


	public function getIndex(){
		return Theme::make('admin/todos/index');
	}

	public function getCreate()
	{
        return Theme::make('admin/todos/create_edit');
	}

	public function postCreate()
	{
        return $this->service->create();
	}

	public function getEdit($todo)
	{
        return Theme::make('admin/todos/create_edit', compact('todo'));
	}

	public function putEdit($todo){
       return $this->service->edit($todo);
	}

    public function deleteIndex($todo)
    {
       return $this->service->delete($todo);
    }

	public function postAssign($todo){
       return $this->service->assign($todo);
	}

     public function getData()
    {
        return $this->service->get();
	}
}
?>