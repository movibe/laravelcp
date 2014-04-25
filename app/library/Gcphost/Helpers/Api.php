<?php namespace Gcphost\Helpers;


class Api {
	static public $type=false;
	

	static public function Enabled() {
		if(self::$type){
			return true;
		} else return false;
	}

	static public function View($data) {
		if(!self::$type || !is_array($data)) return false;
		if(self::$type=='json'){
			header('Content-Type: application/json');
			die(json_encode($data));
		}
		if(self::$type=='xml'){
			header('Content-Type: application/xml; charset=utf-8');
			die(xmlrpc_encode($data));
		}
	}

  	static public function Redirect($data) {
		if(!self::$type) return false;
		self::Display($data);
	}

}