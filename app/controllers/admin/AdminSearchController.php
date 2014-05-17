<?php
class AdminSearchController extends BaseController
{
    protected $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }
	public function getIndex($search)
    {
		return $this->service->index($search);
    }
}