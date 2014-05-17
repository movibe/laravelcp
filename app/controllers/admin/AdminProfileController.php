<?php
class AdminProfileController extends BaseController {
    protected $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }
	
    public function deleteIndex($user, $profile)
    {
		return $this->service->delete($user, $profile);
	}
}
