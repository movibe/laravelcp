<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;
use Zizaco\Entrust\HasRole;

class Api extends ConfideUser  {

	static public function Enabled() {
		if(BaseController::$api){
			return true;
		} else return false;
	}

	static public function Display($data) {
		if(BaseController::$api && is_array($data)){
			if(BaseController::$api=='json') return(json_encode($data));
			if(BaseController::$api=='xml') return(xmlrpc_encode($data));
		}
	}
	static public function Error($data) {
		$this->Display(array('error' => true, 'data'=>$data));
	}
}
