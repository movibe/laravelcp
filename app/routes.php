<?php

Route::model('user', 'User');
Route::model('profile', 'UserProfile');
Route::model('comment', 'Comment');
Route::model('id', 'id');
Route::model('post', 'Post');
Route::model('todo', 'Todos');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('todo', '[0-9]+');
Route::pattern('profile', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('id', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');


/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */

# json api
Route::group(array('prefix' => 'json/admin', 'before' => 'json|auth.basic|checkuser'), function()
{
	Event::fire('json.admin');
	Theme::AdminGroup();
});

# xml api
Route::group(array('prefix' => 'xml/admin', 'before' => 'xml|auth.basic|checkuser'), function()
{
	Event::fire('xml.admin');
	Theme::AdminGroup();
});


# web 
Route::group(array('prefix' => 'admin', 'before' => 'auth|checkuser'), function()
{
	Event::fire('page.admin');
	Theme::AdminGroup();
});




/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

Event::fire('page.site');

Route::get('invalidtoken', 'UserController@invalidtoken');
Route::get('nopermission', 'UserController@noPermission');
Route::get('suspended', 'UserController@suspended');

Route::get('user/reset/{token}', 'UserController@getReset');
Route::post('user/reset/{token}', 'UserController@postReset');

Route::controller('user/{user}/profile/{profile}', 'UserController');
Route::controller('user/{user}', 'UserController');
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::post('contact-us', 'BlogController@postContactUs');
Route::get('contact-us', 'BlogController@getContactUs');

# Get javascript translations
Route::get('translation.js', 'BlogController@getJavascript');


# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
