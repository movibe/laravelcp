<?php
Route::model('user', 'User');
Route::model('profile', 'UserProfile');
Route::model('comment', 'Comment');
Route::model('id', 'id');
Route::model('post', 'Post');
Route::model('todo', 'Todos');
Route::model('role', 'Role');

Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('todo', '[0-9]+');
Route::pattern('profile', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('id', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');
Route::pattern('any', '[0-9a-z].+');

$prefix = Request::segment(1);

if(in_array($prefix, array('admin','json', 'xml'))){
	if(in_array($prefix, array('json', 'xml'))){
		$before = $prefix.'|auth.basic|checkuser';
		$newprefix = $prefix.'/admin';
	} else {
		$before='auth|checkuser';
		$newprefix='admin';
	}

	Route::group(array('prefix' => $newprefix, 'suffix' => array('.json', '.xml', '*'), 'before' => $before), function()
	{
		Event::fire('page.admin');

		# Search
		Search::AddTable('users', array('email', 'displayname', 'id'), array('id' => array('method'=>'modal', 'action'=>'admin/users/?/edit')));
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
		Route::get('user/mass/email', 'AdminEmailController@getEmailMass');
		Route::post('user/mass/email', 'AdminEmailController@postIndex');
		
		Route::delete('user/mass', 'AdminUsersController@postDeleteMass');

		Route::get('user/mass/merge', 'AdminMergeController@getMassMergeConfirm');
		Route::post('user/mass/merge', 'AdminMergeController@postMerge');



		# User Profile Management
		Route::controller('users/{user}/profile/{profile}', 'AdminProfileController');

		# User Email Management
		Route::controller('users/{user}/email', 'AdminEmailController');
		Route::controller('users/email', 'AdminEmailController');
		Route::get('users/{user}/emails', 'AdminEmailController@getEmails');

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
	
	});
} else {

	Route::group(array('prefix' => 'client', 'suffix' => array('.json', '.xml', '*'), 'before' => 'auth|checkuser'), function()
	{
		Event::fire('page.client');
		
		Route::controller('/', 'ClientController');

	});



	Route::get('private/cron',  function()
	{
		header('Content-Type: application/json');
		die(json_encode(CronWrapper::Run()));
	});

	Event::fire('page.site');

	Route::get('invalidtoken', 'UserController@invalidtoken');
	Route::get('nopermission', 'UserController@noPermission');
	Route::get('suspended', 'UserController@suspended');

	Route::get('user/reset/{token}', 'UserController@getReset');
	Route::post('user/reset/{token}', 'UserController@postReset');

	Route::controller('user/{user}/profile/{profile}', 'UserController');
	Route::controller('user/{user}', 'UserController');
	Route::controller('user', 'UserController');

	Route::when('contact-us','detectLang');

	Route::post('contact-us', 'BlogController@postContactUs');
	Route::get('contact-us', 'BlogController@getContactUs');

	Route::get('{postSlug}', 'BlogController@getView');
	Route::post('{postSlug}', 'BlogController@postView');

	Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
}