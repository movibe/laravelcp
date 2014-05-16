<?php
use Illuminate\Filesystem\Filesystem;

class Dashboard extends Eloquent {
	static public function widgets(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$theme=Theme::getTheme();
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."widgets");
		return $files;
	}

	static private function graphData($type, $from, $to, $distinct=false){
		if($distinct){
			 return Activity::whereBetween('created_at', array($from, $to))->where('content_type', '=', $type)->count(DB::raw('distinct `ip_address` '));		
		} else return Activity::whereBetween('created_at', array($from, $to))->where('content_type', '=', $type)->count();
	}

	static public function graph($type='activity', $time=5, $distinct=false){
		$results=array();
		$total=0;
		for($a = 0; $a < $time; $a++){
			$results['data'][$a]=self::graphData($type, Carbon::now()->subWeeks($a+1), Carbon::now()->subWeeks($a), $distinct);
			$total=$total+$results['data'][$a];
		}
		$results['data']=$results['data'];
		$results['medium']=round($total/$time);
		return $results;
	}

	static public function activity(){
		return Activity::whereRaw('UNIX_TIMESTAMP(`activity_log`.`created_at`) > ? AND (activity_log.content_type="notification" OR activity_log.content_type="login")',array(Session::get('usersonline_lastcheck', time())))
							->select(array('description', 'details', 'users.displayname', 'content_type'))
							->groupBy(DB::raw('description, details, users.displayname, content_type'))
							->orderBy('activity_log.id', 'DESC')
							->leftJoin('users', 'users.id', '=', 'activity_log.user_id')
							->get()->toArray();
	}

	static public function online($value=10){
		return DB::select('SELECT email, displayname, id, last_activity FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ? LIMIT ?', array(time()-150, $value));
	}

	static public function onlineTotal(){
		$total=DB::select('SELECT count(*) as total FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ?', array(time()-150));
		return $total[0]->total;
	}

	static public function googleGraph($minigraph_data,$type='activity'){
		switch($type){
			case 'activity':
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
			break;
		}
	}

	static public function poll($polls){
		$polls = json_decode($polls);
		$_results=array();
		if(is_array($polls) && count($polls) > 0){
			foreach($polls as $i => $_poll){
				switch($_poll->type){
					case "template":	
						$_results[$_poll->id]=array('type'=>'html', 'args'=>Theme::make($_poll->func, array('value'=>$_poll->value))->render());
					break;
					case "plugin":	
						if($_poll->func) $_results[$_poll->id]=call_user_func($_poll->func, $_poll->value);
					break;
					case "check_logs":
						$list = Dashboard::activity();
						Session::put('usersonline_lastcheck', time());
						$_results[$_poll->id]=array('type'=>'function', 'func'=>'fnUpdateGrowler', 'args'=>$list);
					break;
				}
			}
		}
		return $_results;
	}
}