<?php

class AdminBlogsController extends BaseController {
    protected $service;

    public function __construct(BlogService $service)
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

	public function getEdit($post)
	{
        return $this->service->getEdit($post);
	}

	public function putEdit($post)
	{
        return $this->service->edit($post);
	}

    public function deleteIndex($post)
    {
        return $this->service->delete($post);
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