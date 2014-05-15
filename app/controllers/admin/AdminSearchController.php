<?php

class AdminSearchController extends AdminController
{

    public function getIndex($search)
    {
		$results=Search::Query($search);
		return Theme::make('admin/search/index', compact('results'));
    }
}