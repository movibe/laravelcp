<?php 

class DashboardService {
	public function index()
	{
		$minigraph_data=array();
		$minigraph_data['account_created']=Dashboard::graph('account_created');
		$minigraph_data['login']=Dashboard::graph('login');
		$minigraph_data['activity']=Dashboard::graph('activity');
		$minigraph_data['activity_unique']=Dashboard::graph('activity','5', true);

		View::share('minigraph_data', $minigraph_data);
		View::share('minigraph_json', json_encode($minigraph_data));

		$widgets=Dashboard::widgets();
		View::share('widgets', $widgets);

		$results=Dashboard::online();
		View::share('whosonline', $results);

		Dashboard::googleGraph($minigraph_data);

		return Theme::make('admin/dashboard/index');
	}

	public function polling(){
		return Response::json(Dashboard::poll(Input::get('polls')));
	}

}