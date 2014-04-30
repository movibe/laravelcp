<?php namespace Gcphost\Helpers;


class Api {
	static public $type=false;
	

	static public function Enabled() {
		if(self::$type){
			return true;
		} else return false;
	}

	static public function make($data) {
		if(!self::$type || !is_array($data)) return false;
		$dd=array();
		foreach($data as $d){
			if(is_object($d)){
				$dd[]=$d->toArray();
			}if(is_array($d)){
				$dd[]=$d;
			}else $dd[]=array($d);
		}

		if(self::$type=='json'){
			header('Content-Type: application/json');
			die(json_encode($dd));
		}
		if(self::$type=='xml'){
			header('Content-Type: application/xml; charset=utf-8');
			die(xmlrpc_encode($dd));
		}
		return false;
	}

  	static public function to($data) {
		// wrapper for failure/success
		return self::make($data);
	}

  	static public function json($data) {
		return !self::$type ? json_encode($data) : self::View($data);
	}

}