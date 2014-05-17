<?php
class AdminDashboardController extends BaseController {
    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }
	
	public function getIndex()
	{
		return $this->service->index();
	}

	public function postPolling(){
		return $this->service->polling();
	}
}