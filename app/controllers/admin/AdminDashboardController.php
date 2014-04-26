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
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."widgets");
		return $files;
	}



	public function getIndex()
	{
		$widgets=$this->widgets();
		View::share('widgets', $widgets);


		$results=DB::select('SELECT email FROM users WHERE last_activity > ?', array(time()-600));
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


		return View::make('admin/dashboard');
	}

	public function postPolling(){
			$polls = json_decode(Input::get('polls'));
			$_results=array();
			if(is_array($polls) && count($polls) > 0){
				foreach($polls as $i => $_poll){
					switch($_poll->type){
						/*
							type: function or html
								html: results are passed back in the 'args' field and updated to the element defined in fnAddPoll
								function: results are passed back to the function, func, with whatever results you want, example parses an array				
						*/
						case "check_logs":
							$_results[$_poll->id]=array('type'=>'function', 'func'=>'fnUpdateGrowler', 'args'=>array('Notifaction triggered'));
						break;
						case "users_online":
							$_results[$_poll->id]=array('type'=>'html', 'args'=>View::make('admin/helpers/users-online')->render());
						break;
					}

				}
			}
		return Response::json($_results);
	}
}