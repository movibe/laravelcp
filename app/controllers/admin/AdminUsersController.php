<?php
class AdminUsersController extends BaseController {
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getList()
    {
		return $this->service->listusers();
	}

    public function getListadmin()
    {
		return $this->service->listadmins();
	}

    public function getIndex()
    {
		return $this->service->index();
    }

    public function getSwitch($user)
    {
		return $this->service->switchuser($user);
    }

    public function getCreate()
    {
		return $this->service->getCreate();
    }

    public function postCreate()
    {
  		return $this->service->create();
    }

	 public function getActivity($user){
  		return $this->service->activity($user);
	 }

    public function getNotes($user)
    {
  		return $this->service->notes($user);
	}

	public function postResetpassword($user){
  		return $this->service->resetpassword($user);
	}

	public function getEdit($user)
    {
  		return $this->service->getEdit($user);
    }

    public function putEdit($user)
    {
  		return $this->service->edit($user);
    }

    public function postDeleteMass()
    {
  		return $this->service->deletemass();
	}

    public function deleteIndex($user)
    {
		return $this->service->delete($user);
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