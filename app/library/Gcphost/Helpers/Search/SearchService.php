<?php 

class SearchService {
	public function index($search)
    {
		$results=Search::Query($search);
		return Theme::make('admin/search/index', compact('results'));
    }

}