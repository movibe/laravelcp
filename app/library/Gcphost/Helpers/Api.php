<?php namespace Gcphost\Helpers;


class Api {
	static public $type=false;
	

	static public function Enabled() {
		if(self::$type){
			return true;
		} else return false;
	}

	static public function Display($data) {
		if(self::$type && is_array($data)){
			if(self::$type=='json') return(json_encode($data));
			if(self::$type=='xml') return(xmlrpc_encode($data));
		}
	}
	static public function Error($data) {
		self::Display(array('success' => false, 'data'=>$data));
	}
   

}