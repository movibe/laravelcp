<?php namespace Gcphost\Helpers;


class Theme {
	static private $tables=array();
	static private $actions=array();
	static private $path;
	
	private function getTemplates(){
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0]);
		return $files;
	}

	static public function path($file){
		return self::exists($file) ? : $file;
	}

	static private function exists($file){
		$ext = pathinfo($file);

		$theme=self::getTheme();

		$path=\Config::get('view.paths');
		
		$check_file=!isset($ext['extension']) ? $file.'.blade.php': $file;

		$check=$path[0].DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$check_file;
		
		return is_file($check) ? $theme.DIRECTORY_SEPARATOR.$file : false;
	}


	static public function make($file, $data=array()){
		return \View::make(self::path($file), $data);
	}

	static public function getTheme(){
		$theme=\Setting::get('site.theme');
		$path=\Config::get('view.paths');

		return is_dir($path[0].DIRECTORY_SEPARATOR.$theme) ? $theme : false;
	}
}