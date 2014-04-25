<?php namespace Gcphost\Helpers;


class Search {
	static private $tables=array();

	static public function Query($string){
		if(!$string || strlen($string) < 3) return array();
		$results=array();
		foreach(self::$tables as $table => $columns){

			$query=\DB::table($table);
			$i=0;
			foreach($columns as $column){
				if($i==0){
                   $query->where($column, 'LIKE', '%'.$string.'%');
				}else $query->orWhere($column, 'LIKE', '%'.$string.'%');
				$i++;
			}

			if($query->count() > 0)$results[$table]=$query->get($columns);
		}
		return $results;
	}

	static public function AddTable($table, $columns){
		self::$tables[$table]=$columns;
	}
	
}