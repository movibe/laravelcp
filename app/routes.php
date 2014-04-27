<?php



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

/*
example for hooking into the navigation among other items

Event::listen('page.admin', function()
{

});

View::composer('*navigation', function($view)
{
    $view->nest('test','admin/test');
});
*/

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */

# json api
Route::group(array('prefix' => 'json/admin', 'before' => 'json|auth.basic|checkuser'), function()
{
	Event::fire('json.admin');

	Route::controller('users/{user}', 'AdminUsersController');
	Route::controller('users', 'AdminUsersController');

});

# xml api
Route::group(array('prefix' => 'xml/admin', 'before' => 'xml|auth.basic|checkuser'), function()
{
	Event::fire('xml.admin');

	Route::controller('users/{user}', 'AdminUsersController');
	Route::controller('users', 'AdminUsersController');
});


# web 
Route::group(array('prefix' => 'admin', 'before' => 'auth|checkuser'), function()
{
	Event::fire('page.admin');

	# Search
	Search::AddTable('users', array('email'), array('id' => array('method'=>'modal', 'action'=>'admin/users/?/edit')));
	Search::AddTable('posts', array('title','slug','content','meta_title','meta_description','meta_keywords'), array('id' => array('method'=>'modal', 'action'=>'admin/slugs/?/edit')));
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

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
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


# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
