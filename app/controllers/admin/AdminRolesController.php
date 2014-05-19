<?php
class AdminRolesController extends BaseController {
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

	public function getIndex()
    {
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

    public function getEdit($role)
    {
       return $this->service->getEdit($role);
    }

    public function putEdit($role)
    {
       return $this->service->edit($role);
    }

    public function deleteIndex($role)
    {
       return $this->service->delete($role);
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