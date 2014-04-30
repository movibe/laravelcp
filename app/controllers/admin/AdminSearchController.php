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
		return Theme::make('admin/search', compact('results'));
    }
}