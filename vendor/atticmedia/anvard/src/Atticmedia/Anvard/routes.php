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

                /**
                 * added the detection / redirection script for easier customization
                 */
                if(Session::has('login_redirect_url')) {
                    $redirect_url = Session::get('login_redirect_url');
                    Session::forget('login_redirect_url');
                    return Redirect::to($redirect_url);
                }

                /**
                 * Added default redirect location if needed.
                 */
                if(Config::get('anvard::routes.loginredirect')){
                    return Redirect::to(Config::get('anvard::routes.loginredirect'));
                }

                return Redirect::back();
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
if (Config::get('anvard::routes.logout')) {
    Route::get(
        Config::get('anvard::routes.logout'),
        array(
            'as' => 'anvard.routes.logout',
            function() {
                $hybridAuth = App::make('hybridauth');

                // logout all providers
                $hybridAuth->logoutAllProviders();

                // logout of laravel
                Auth::logout();

                // redirect someplace or back.
                if (Config::get('anvard::routes.logoutredirect')) {
                    return Redirect::to(Config::get('anvard::routes.logoutredirect'));
                }
                else {
                    return Redirect::back();
                }
            }
        )
    );
}