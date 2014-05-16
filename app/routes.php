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
if(in_array($prefix, array('json', 'xml')) && $prefix != 'admin'){
	$before = $prefix.'|auth.basic|checkuser';
	$prefix = $prefix.'/admin';
} else {
	$before='auth|checkuser';
	$prefix='admin';
}

Route::group(array('prefix' => $prefix, 'suffix' => array('.json', '.xml', '*'), 'before' => $before), function()
{
	Event::fire('page.admin');
	Theme::AdminGroup();
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