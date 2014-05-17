<?php

class AdminEmailController extends BaseController {
    protected $service;

    public function __construct(EmailService $service)
    {
        $this->service = $service;
    }

	
	 public function getEmails($user){
		return $this->service->emails($user);
	 }
   
    public function getIndex($user)
    {
       return $this->service->index($user);
    }

    public function postIndex($user=false)
    {
       return $this->service->post($user);
    }

	public function getEmailMass(){
       return $this->service->emailmass();
	}
}