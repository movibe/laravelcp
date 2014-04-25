<?php

class AdminSearchController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getIndex($search)
    {
		$results=Search::Query($search);
		if(!Api::View(compact('results'))) return View::make('admin/search', compact('results'));
    }
}