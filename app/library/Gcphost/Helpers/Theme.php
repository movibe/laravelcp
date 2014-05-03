<?php namespace Gcphost\Helpers;

//use Search;
use Route;
use View;
use Config;
use Setting;

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

		$path=Config::get('view.paths');
		
		$check_file=!isset($ext['extension']) ? $file.'.blade.php': $file;

		$check=$path[0].DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$check_file;
		
		return is_file($check) ? $theme.DIRECTORY_SEPARATOR.$file : false;
	}


	static public function make($file, $data=array()){
		return Api::make($data) ? : View::make(self::path($file), $data);
	}

	static public function getTheme(){
		$theme=Setting::get('site.theme');
		$path=Config::get('view.paths');

		return is_dir($path[0].DIRECTORY_SEPARATOR.$theme) ? $theme : false;
	}

	static public function AdminGroup(){

		# Search
		Search::AddTable('users', array('email'), array('id' => array('method'=>'modal', 'action'=>'admin/users/?/edit')));
		Search::AddTable('posts', array('title','slug','content','meta_title','meta_description','meta_keywords'), array('id' => array('method'=>'modal', 'action'=>'admin/slugs/?/edit')));
		Search::AddTable('todos', array('title','description'), array('id' => array('method'=>'modal', 'action'=>'admin/todos/?/edit')));
		Route::controller('search/{postSlug}', 'AdminSearchController');

		# Settings Management
		Route::controller('settings', 'AdminSettingsController');

		# Comment Management
		Route::controller('comments/{comment}', 'AdminCommentsController');
		Route::controller('comments', 'AdminCommentsController');

		# Slug Management
		Route::controller('slugs/{post}', 'AdminBlogsController');
		Route::controller('slugs', 'AdminBlogsController');

		# User Mass Management
		Route::get('user/mass/email', 'AdminUsersController@getEmailMass');
		Route::post('user/mass/email', 'AdminUsersController@postEmail');
		Route::get('user/mass/merge', 'AdminUsersController@getMassMergeConfirm');
		Route::post('user/mass/merge', 'AdminUsersController@postMerge');
		Route::delete('user/mass', 'AdminUsersController@postDeleteMass');


		# User Profile Management
		Route::controller('users/{user}/profile/{profile}', 'AdminProfileController');

		# User Management
		Route::controller('users/{user}', 'AdminUsersController');
		Route::controller('users', 'AdminUsersController');
		

		# User Role Management
		Route::controller('roles/{role}', 'AdminRolesController');
		Route::controller('roles', 'AdminRolesController');

		# Todos
		Route::controller('todos/{todo}', 'AdminTodosController');
		Route::controller('todos', 'AdminTodosController');
	   
		# Admin Dashboard
		Route::controller('/', 'AdminDashboardController');
	}

}