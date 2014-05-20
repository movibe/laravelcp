<?php
class UserController extends BaseController {
    protected $service;

    public function __construct(SiteUserService $service)
    {
        $this->service = $service;
    }

	public function getCancel($user, $token){
		return $this->service->cancel();
	}

    public function invalidtoken()
    {
		return $this->service->invalidtoken();
    }   
	
    public function noPermission()
    {
		return $this->service->noPermission();
    }

    public function suspended()
    {
		return $this->service->suspended();
    }
	
    public function getIndex()
    {
		return $this->service->index();
    }

    public function postIndex()
    {
		return $this->service->post();
    }

    public function postEdit($user)
    {
		return $this->service->edit($user);
    }

    public function getCreate()
    {
		return $this->service->getCreate();
    }

    public function getDelete($user, $profile)
    {
		return $this->service->getDelete($user, $profile);
	}

    public function getLogin()
    {
		return $this->service->getLogin();
    }

    public function postLogin()
    {
		return $this->service->postLogin();
    }

    public function getConfirm($code)
    {
		return $this->service->getConfirm($code);
    }

    public function getForgot()
    {
		return $this->service->getForgot();
    }

    public function postForgot()
    {
		return $this->service->postForgot();
    }

    public function getReset($token)
    {
		return $this->service->getReset($token);
    }
  
    public function postReset()
    {
		return $this->service->postReset();
    }

    public function getLogout()
    {
		return $this->service->getLogout();
    }

	public function getSettings()
    {
		return $this->service->getSettings();
    }
}