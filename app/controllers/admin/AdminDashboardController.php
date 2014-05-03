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


	private function graphData($type, $from, $to, $distinct=false){
		if($distinct){
			return Activity::select(DB::raw('distinct `ip_address` '))->whereBetween('created_at', array($from, $to))->where('content_type', '=', $type)->count();
		} else return Activity::whereBetween('created_at', array($from, $to))->where('content_type', '=', $type)->count();
	}

	private function graphDataBuild($type='activity', $time=5, $distinct=false){
		$results=array();
		$total=0;
		for($a = 0; $a < $time; $a++){
			$results['data'][$a]=$this->graphData($type, Carbon::now()->subWeeks($a+1), Carbon::now()->subWeeks($a), $distinct);
			$total=$total+$results['data'][$a];
		}
		$results['data']=$results['data'];
		$results['medium']=round($total/$time);
		return $results;
	}


	public function getIndex()
	{

		$minigraph_data=array();
		$minigraph_data['account_created']=$this->graphDataBuild('account_created');
		$minigraph_data['login']=$this->graphDataBuild('login');
		$minigraph_data['activity']=$this->graphDataBuild('activity');
		$minigraph_data['activity_unique']=$this->graphDataBuild('activity','5', true);
		View::share('minigraph_data', $minigraph_data);
		View::share('minigraph_json', json_encode($minigraph_data));

		$widgets=$this->widgets();
		View::share('widgets', $widgets);

		$results=DB::select('SELECT email FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ?', array(time()-600));
		View::share('whosonline', $results);

		$stocksTable = Lava::DataTable('Stocks');
		$stocksTable->addColumn('string', 'Week', 'count');
		$stocksTable->addColumn('number', 'Hits', 'projected');
		$stocksTable->addColumn('number', 'Unique', 'projected');
		
		foreach(array_reverse($minigraph_data['activity']['data'],true) as $i=>$d){
			
			$data[0]=$i==0 ? "This week" : Carbon::now()->subWeeks($i)->diffForHumans(); 
			$data[1] = $d; 
			$data[2] = $minigraph_data['activity_unique']['data'][$i];

			$stocksTable->addRow($data);

		}
		Lava::LineChart('Stocks')->setConfig();


		return Theme::make('admin/dashboard');
	}



	public function postPolling(){

		$polls = json_decode(Input::get('polls'));
		$_results=array();
		if(is_array($polls) && count($polls) > 0){
			foreach($polls as $i => $_poll){
				switch($_poll->type){
					case "plugin":	
						if($_poll->func) $_results[$_poll->id]=call_user_func($_poll->func, $_poll->value);						
					break;
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