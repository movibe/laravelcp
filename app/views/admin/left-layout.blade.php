@section('styles')
	<link href="{{{ asset('assets/css/left-layout.css') }}}" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
	<div class="well col-sm-3 col-md-3 sidebar @if (trim($__env->yieldContent('breadcrumb')))sidebar-with-bread@endif">
		@yield('left-layout-nav')

		 @if (Auth::user()->hasRole('admin'))
			 <ul class="list-group">
			  <li class="list-group-item list-group-item-info">
				<span class="badge">{{DB::table('users')->where('last_activity', '>', time()-600)->count() }}</span>
				{{{ Lang::get('core.users_online') }}}
			  </li>
				@foreach (DB::select('SELECT email, displayname FROM users WHERE last_activity > ? LIMIT 5', array(time()-600)) as $row)
					<li class="list-group-item">{{{ isset($row->displayname) ? $row->displayname : $row->email }}}</li>
				@endforeach
			</ul>
		@endif
	</div>
	<div class="col-sm-9 col-md-9 col-md-offset-3 col-sm-offset-3 main">
		@yield('left-layout-content')
	</div>
  </div>
 </div>
@stop