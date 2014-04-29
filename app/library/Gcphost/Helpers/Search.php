<?php namespace Gcphost\Helpers;


class Search {
	static private $tables=array();
	static private $actions=array();

	static public function Query($string){
		$tables=self::$tables;
	
		$smart=explode(' ', $string);
		if(count($smart) > 0){
			if(array_key_exists($smart[0], $tables)){
				$tables=array($smart[0]=>$tables[$smart[0]]);
				$string=preg_replace("/".$smart[0]." /i", '', $string, 1);
			}
		}

		if(!$string || strlen($string) < 3) return array();
		$results=array();
		foreach($tables as $table => $columns){

			$query=\DB::table($table);
			$i=0;
			foreach($columns as $column){
				if($i==0){
                   $query->where($column, 'LIKE', '%'.$string.'%');
				}else $query->orWhere($column, 'LIKE', '%'.$string.'%');
				$i++;
			}

			if($query->count() > 0) $results[$table]=$query->get(array_merge(array('id'),$columns));
		}
		return $results;
	}

	static public function AddTable($table, $columns, $actions){
		self::$tables[$table]=$columns;
		self::$actions[$table]=$actions;
	}

	static public function GetAction($table, $column){

		foreach(self::$actions[$table] as $col=>$action){
			if($col == $column) return $action;
		}
	}
	
}