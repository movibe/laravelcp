<?php
use Gcphost\LaravelCP\Comment\CommentRepository as Comment;

class AdminCommentsController extends BaseController
{
    protected $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function getIndex()
    {
        return $this->service->index();
    }

	public function getEdit($comment)
	{
        return $this->service->getEdit($comment);
	}

	public function putEdit($comment)
	{
        return $this->service->edit($comment);
	}

	public function deleteIndex($comment)
	{
        return $this->service->delete($comment);
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