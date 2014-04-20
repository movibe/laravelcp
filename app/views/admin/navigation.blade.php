<div class="navbar navbar-default navbar-fixed-top main-nav">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{{ URL::to('admin') }}}" class="navbar-brand">{{{ Setting::get('site.name') }}} </a>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				@yield('main-nav-pre')
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a id="nav_users" class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
						<span class="glyphicon glyphicon-user"></span> {{{ Lang::get('core.users') }}} <span class="caret"></span>
					</a>
					<ul aria-labelledby="nav_users" class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> {{{ Lang::get('core.users') }}}</a></li>
						<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-warning-sign"></span> {{{ Lang::get('Roles') }}}</a></li>
					</ul>
				</li>
				@yield('main-nav-post')
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@yield('sub-nav-pre')
				<li class="dropdown{{ (Request::is('admin/settings*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/Products') }}}">
						<span class="glyphicon glyphicon-cog"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/settings*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/settings') }}}"><span class="glyphicon glyphicon-th-list"></span> {{{ Lang::get('core.settings') }}}</a></li>
						<li{{ (Request::is('admin/slugs*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/slugs') }}}"><span class="glyphicon glyphicon-list-alt"></span> {{{ Lang::get('core.slugs') }}}</a></li>						
						<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span> {{{ Lang::get('core.comments') }}}</a></li>
						@yield('sub-nav-settings')
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon"><img alt="{{{ Auth::user()->email }}}" src="{{ Gravatar::src(Auth::user()->email, 20) }}"></span> {{{ Auth::user()->email }}}	<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-wrench"></span> {{{ Lang::get('core.profile') }}}</a></li>
						<li class="divider"></li>
						<li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> {{{ Lang::get('core.logout') }}}</a></li>
						@yield('sub-nav-user')
					</ul>
				</li>
				@yield('sub-nav-post')
			</ul>
		</div>
	</div>
</div>