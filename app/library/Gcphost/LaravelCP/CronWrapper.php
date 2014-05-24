<?php namespace Gcphost\LaravelCP;

use Cron;

class CronWrapper {
	static private $actions=array();

	static public function Run(){
		foreach(self::$actions as $action) call_user_func($action);
		Cron::setLogOnlyErrorJobsToDatabase(false);
		return Cron::run();
	}

	static public function Add($actions){
		self::$actions[]=$actions;
	}
}

