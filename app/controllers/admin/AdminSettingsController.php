<?php
class AdminSettingsController extends BaseController
{
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }
	
	public function getIndex()
    {
		return $this->service->index();
    }
   
	public function postIndex()
	{
		return $this->service->post();
	}
}