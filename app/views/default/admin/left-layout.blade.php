@section('styles')
	<link href="{{{ asset('assets/css/left-layout.css') }}}" rel="stylesheet">
@stop

@section('navbar-header')
	<button type="button" class="fa fa-bars navbar-toggle hidden-sm hidden-md hidden-lg pull-left subnav-toggle" data-toggle="collapse" data-target=".sidebar"></button>
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
	<div class=" well col-xs-10 col-sm-3 col-md-3 sidebar @if (trim($__env->yieldContent('breadcrumb')))sidebar-with-bread@endif">
		@yield('left-layout-nav')

		 @if (Auth::user()->hasRole('admin'))
			<br/>
			 <ul class="list-group">
			  <li class="list-group-item list-group-item-info">
				<span class="badge">{{ count(DB::select('SELECT id FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ?', array(time()-150))) }}</span>
				{{{ Lang::get('core.users_online') }}}
			  </li>
			</ul>
		@endif
	</div>
	<div class="col-sm-9 col-md-9 col-md-offset-3 col-sm-offset-3 main">
		<br/>
		@include(Theme::path('notifications'))
		@yield('left-layout-content')
	</div>
  </div>
 </div>
@stop