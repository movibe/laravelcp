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
			#logo{
				background: url("data:image/png;base64,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");
				float: left;
				width: 40px;
				height: 40px;
				margin-top: 5px;
				margin-right: 8px;
				margin-left: 5px;
			}

			body{ padding-top: 60px}
		@section('styles')
		@show
		@yield('styles')
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
                    <div id="logo"></div>
					<a href="{{{ URL::to('/') }}}" class="navbar-brand">{{{ Setting::get('site.name') }}}</a>
					<button type="button" class="fa fa-lg fa-bars hidden-sm hidden-md hidden-lg navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">{{{ Lang::get('core.toggle_nav') }}}</span>
					</button>
                </div>
                <div class="collapse navbar-collapse">
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
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<span class="glyphicon"><img alt="{{{ Auth::user()->email }}}" src="{{ Gravatar::src(Auth::user()->email, 20) }}"></span>  &nbsp; {{{ Auth::user()->email }}}	<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="{{{ URL::to('admin') }}}">{{{ Lang::get('site.admin_panel') }}}</a></li>
									<li class="divider"></li>
									<li><a href="{{{ URL::to('user/logout') }}}">{{{ Lang::get('core.logout') }}}</a></li>
								</ul>
							</li>
							@else
								<li><a href="{{{ URL::to('user/logout') }}}">{{{ Lang::get('core.logout') }}}</a></li>
							@endif
                        @else
							<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">{{{ Lang::get('user/user.login') }}}</a></li>
							<li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
                        @endif
                    </ul>
				</div>
			</div>
		</div>

		<div class="container">
			@include(Theme::path('notifications'))

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

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.2.0/bootbox.min.js"></script>

	@yield('scripts')
</body>
</html>
