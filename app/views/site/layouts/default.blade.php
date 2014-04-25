<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>
			@section('title')
				{{{ Setting::get('site.name') }}}
			@show
		</title>
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="description" content="" />
		<meta name="csrf-token" content="{{{ csrf_token() }}}"/>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="//bootswatch.com/{{{ Setting::get('site.bootswatch') }}}/bootstrap.min.css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<style type="text/css">


		body{ padding-top: 60px}
		@section('styles')
		@show
		</style>

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	</head>

	<body>
		<div id="wrap">
		<div class="navbar navbar-default  navbar-fixed-top">
			 <div class="container">
                <div class="navbar-header">
                    <a href="{{{ URL::to('/') }}}" class="navbar-brand">{{{ Setting::get('site.name') }}}</a>
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">{{{ Lang::get('core.toggle_nav') }}}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
						<li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">{{{ Lang::get('site.home') }}}</a></li>
						<li {{ (Request::is('contact-us') ? ' class="active"' : '') }}><a href="{{{ URL::to('contact-us') }}}">{{{ Lang::get('site.contactus') }}}</a></li>
						@foreach (DB::select('SELECT title, slug FROM posts WHERE parent = 0 AND display_navigation = 1') as $row)
							<li {{ (Request::is($row->slug) ? ' class="active"' : '') }}>
								<a href="{{{ URL::to($row->slug) }}}">
										{{{ $row->title }}}
								</a>
							</li>
						@endforeach
					</ul>

                    <ul class="nav navbar-nav pull-right">
                        @if (Auth::check())
                        @if (Auth::user()->hasRole('admin'))
                        <li><a href="{{{ URL::to('admin') }}}">{{{ Lang::get('site.admin_panel') }}}</a></li>
                        @endif
                        <li><a href="{{{ URL::to('user') }}}">{{{ Lang::get('site.loggedinas') }}} {{{ Auth::user()->email }}}</a></li>
                        <li><a href="{{{ URL::to('user/logout') }}}">{{{ Lang::get('core.logout') }}}</a></li>
                        @else
                        <li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">{{{ Lang::get('user/user.login') }}}</a></li>
                        <li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
                        @endif
                    </ul>
				</div>
			</div>
		</div>

		<div class="container">
			@include('notifications')

			@yield('content')
			<hr/>
		</div>

		<div id="push"></div>
		</div>


	    <div id="footer">
	      <div class="container">
	        <p class="muted credit">&copy; {{ date('Y') }} {{{ Setting::get('site.name') }}}</p>
	      </div>
	    </div>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
	@yield('scripts')
</body>
</html>
