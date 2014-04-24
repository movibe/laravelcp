<?php

if (Config::get('anvard::routes.index')) {
    Route::get(
        Config::get('anvard::routes.index'),
        array(
            'as' => 'anvard.routes.index',
            function() {
                $anvard = App::make('anvard');
                $providers = $anvard->getProviders();
                return View::make(Config::get('anvard::views.index'), compact('providers'));
            }
        )
    );
}
if (Config::get('anvard::routes.login')) {
    Route::get(
        Config::get('anvard::routes.login'),
        array(
            'as' => 'anvard.routes.login',
            function($provider) {
                Log::debug('Anvard: attempting login');
                $profile = App::make('anvard')->attemptAuthentication($provider, App::make('hybridauth'));
                Log::debug('Anvard: login attempt complete');
                if ($profile) {
                    Log::debug('Anvard: login success');
                    Auth::loginUsingId($profile->user->id);
                } else {
                    Log::debug('Anvard: login failure');
                    Session::flash('anvard', 'Failed to log in!');
                }
				$r = Session::get('loginRedirect');
				if (!empty($r))
				{
					Session::forget('loginRedirect');
					return Redirect::to($r);
				}
				return Redirect::to('/admin');
				}
        )
    );
}
if (Config::get('anvard::routes.endpoint')) {
    Route::get(
        Config::get('anvard::routes.endpoint'),
        array(
            'as' => 'anvard.routes.endpoint',
            function() {
                Hybrid_Endpoint::process();
            }
        )
    );
}
