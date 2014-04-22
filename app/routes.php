<?php

Route::filter('json', function(){BaseController::$api='json';});
Route::filter('xml', function(){BaseController::$api='xml';});
Route::when('*.json', 'json');
Route::when('*.xml', 'xml');

Route::model('user', 'User');
Route::model('profile', 'UserProfile');
Route::model('comment', 'Comment');
Route::model('id', 'id');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('profile', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('id', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */




Route::filter('checkuser', function()
{
	if (Auth::check()){
		DB::update('UPDATE users SET last_activity = ? WHERE id = ?', array(date( 'Y-m-d H:i:s', time()), Auth::user()->id));

		Activity::log(array(
			'contentID'   => Confide::user()->id,
			'contentType' => 'activity',
			'description' => 'Page Loaded',
			'details'     => '<a href="'.$_SERVER['REQUEST_URI'].'" target="_new" class="btn">link</a>',
			'updated'     => Confide::user()->id ? true : false,
		));


		if(Auth::user()->confirmed != '1'){
			Confide::logout();
			return Redirect::to('suspended');
		}
	}
});






Route::group(array('prefix' => 'admin', 'before' => 'auth|checkuser'), function()
{
    Route::controller('users.json', 'AdminUsersController');
    Route::controller('users.xml', 'AdminUsersController');

});

Route::group(array('prefix' => 'admin', 'before' => 'auth|checkuser'), function()
{


    # Settings Management
    Route::get('settings', 'AdminSettingsController@getIndex');
    Route::post('settings', 'AdminSettingsController@postEdit');
    Route::controller('settings', 'AdminSettingsController');


    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('slugs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('slugs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('slugs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::post('slugs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('slugs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/email', 'AdminUsersController@getEmail');
    Route::post('users/{user}/email', 'AdminUsersController@postEmail');
    Route::get('user/mass/email', 'AdminUsersController@getEmailMass');
    Route::post('user/mass/email', 'AdminUsersController@postEmail');

	Route::get('users/{user}/profile/{profile}/delete', 'AdminUsersController@postProfileDelete');


	Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::get('users/{user}/activity', 'AdminUsersController@getActivity');
    Route::get('users/{user}/emails', 'AdminUsersController@getEmails');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::post('user/mass/delete', 'AdminUsersController@postDeleteMass');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

Route::get('nopermission', 'UserController@noPermission');
Route::get('suspended', 'UserController@suspended');

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});


Route::group(array('prefix' => 'cart'), function()
{
    Route::get('delete/{id}', 'CartController@getDelete');
    Route::post('edit/{id}', 'CartController@postEdit');
    Route::post('add/{id}', 'CartController@postCreate');
    Route::controller('', 'CartController');
});


# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
