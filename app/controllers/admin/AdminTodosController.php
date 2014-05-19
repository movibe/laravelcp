<?php
class AdminTodosController extends BaseController {
    protected $service;

    public function __construct(TodosService $service)
    {
        $this->service = $service;
    }

	public function getIndex(){
        return $this->service->index();
	}

	public function getCreate()
	{
        return $this->service->getCreate();
	}

	public function postCreate()
	{
        return $this->service->create();
	}

	public function getEdit($todo)
	{
       return $this->service->getEdit($todo);
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

    public function getPage()
    {
        return $this->service->page(Input::get('limit'));
	}

	public function getData()
    {
        return $this->service->get();
	}
}
?>