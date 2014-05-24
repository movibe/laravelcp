<?php
View::composer(array('*view_post'), function($view) 
{
	$viewdata=$view->getData();
	if(!Auth::check()) return $view->nest('commentForm', 'default/site/blog/comment_auth');
	if(!$viewdata['canComment']) return $view->nest('commentForm', 'default/site/blog/comment_perm');
	return $view->nest('commentForm', 'default/site/blog/comment_form', array('post' => $viewdata['post']));
});

Route::filter('json', function(){Api::$type='json';});
Route::filter('xml', function(){ Api::$type='xml';});

Route::when('json', 'json');
Route::when('xml', 'xml');

Route::filter('auth', function($route, $request)
{
	if (Auth::guest()) {
        if (!Request::ajax()) Session::put('loginRedirect', Request::url());
        return Redirect::to('user/login/');
    }
});

Route::filter('checkuser', function()
{
	if (Auth::check()){
		DB::update('UPDATE users SET last_activity = ? WHERE id = ?', array(date( 'Y-m-d H:i:s', time()), Auth::user()->id));
		if (!Request::ajax()){
			Activity::log(array(
				'contentID'   => Confide::user()->id,
				'contentType' => 'activity',
				'description' => 'Page Loaded',
				'details'     => '<a href="'.$_SERVER['REQUEST_URI'].'" target="_new" class="btn">link</a>',
				'updated'     => Confide::user()->id ? true : false,
			));
		}


		$value = Cache::remember('valid_user', '1', function()
		{
			return Auth::user()->confirmed != '1' ? true : false;
		});
		if($value){
			Confide::logout();
			return Redirect::to('suspended');
		}
	}
});



Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('user/login/');
});


if (Auth::check()){

	$client_roles = Cache::remember('client_roles', '60', function()
	{
		return Role::where('access', '=','client')->lists('name');
	});

	$admin_roles = Cache::remember('admin_roles', '60', function()
	{
		return Role::where('access', '=','admin')->lists('name');
	});

	Entrust::routeNeedsRole( 'client*', $client_roles, Redirect::to('/nopermission'), false );
	Entrust::routeNeedsRole( 'admin*', $admin_roles, Redirect::to('/nopermission'), false );
}

Entrust::routeNeedsPermission( 'admin/slugs*', 'manage_blogs', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/comments*', 'manage_comments', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/users*', 'manage_users', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/roles*', 'manage_roles', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/settings*', 'manage_settings', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/search*', 'site_search', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/todos*', 'manage_todos', Redirect::to('/admin') );

Route::filter('csrf', function()
{
	if (Session::getToken() != Input::get('csrf_token') &&  Session::getToken() != Input::get('_token'))
	{
		return Redirect::to('invalidtoken');
	}
});

Route::filter('detectLang',  function($route, $request, $lang = 'auto')
{
    if($lang != "auto" && in_array($lang , Config::get('app.available_language')))
    {
        Config::set('app.locale', $lang);
    }else{
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0,2);
        $userLang = (in_array($browser_lang, Config::get('app.available_language'))) ? $browser_lang : Config::get('app.locale');
        Config::set('app.locale', $userLang);
        App::setLocale($userLang);
    }
});