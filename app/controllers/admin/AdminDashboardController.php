<?php
use Illuminate\Filesystem\Filesystem;

class AdminDashboardController extends AdminController {

	/**
	 * Admin dashboard
	 *
	 */

	private function widgets(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$theme=Theme::getTheme();
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."widgets");
		return $files;
	}



	public function getIndex()
	{
		$widgets=$this->widgets();
		View::share('widgets', $widgets);

		$results=DB::select('SELECT email FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ?', array(time()-600));
		View::share('whosonline', $results);

		$stocksTable = Lava::DataTable('Stocks');
		$stocksTable->addColumn('number', 'Count', 'count');
		$stocksTable->addColumn('number', 'Projected', 'projected');
		$stocksTable->addColumn('number', 'Official', 'official');
		for($a = 1; $a < 25; $a++)
		{
			$data[0] = $a;              //Count
			$data[1] = rand(800,1000);  //Projected Data
			$data[2] = rand(800,1000);  //Official Data

			$stocksTable->addRow($data);
		}
		$config = array(
			'title' => 'My Stocks'
		);
		Lava::LineChart('Stocks')->setConfig($config);


		return Theme::make('admin/dashboard');
	}

	public function postPolling(){

		$polls = json_decode(Input::get('polls'));
		$_results=array();
		if(is_array($polls) && count($polls) > 0){
			foreach($polls as $i => $_poll){
				switch($_poll->type){
					case "check_logs":
						$list = Activity::
							whereRaw('UNIX_TIMESTAMP(`activity_log`.`created_at`) > ? AND (activity_log.content_type="notification" OR activity_log.content_type="login")',array(Session::get('usersonline_lastcheck', time())))->select(array('description', 'details', 'users.displayname', 'content_type'))->groupBy(DB::raw('description, details, users.displayname, content_type'))->orderBy('activity_log.id', 'DESC')
							->leftJoin('users', 'users.id', '=', 'activity_log.user_id')
							->get()->toArray();
						Session::put('usersonline_lastcheck', time());
						$_results[$_poll->id]=array('type'=>'function', 'func'=>'fnUpdateGrowler', 'args'=>$list);
					break;
					case "users_online":
						$_results[$_poll->id]=array('type'=>'html', 'args'=>Theme::make('admin/helpers/users-online')->render());
					break;
				}
			}
		}
		return Response::json($_results);
	}
}