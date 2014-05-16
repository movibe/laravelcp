@section('navbar-header')
	<button type="button" class="fa fa-bars navbar-toggle hidden-sm hidden-md hidden-lg pull-left subnav-toggle" data-toggle="collapse" data-target=".sidebar"></button>
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
	<div class="hidden-xs  well col-xs-10 col-sm-3 col-md-3 sidebar @if (trim($__env->yieldContent('breadcrumb')))sidebar-with-bread@endif">
		@yield('left-layout-nav')

		 @if (Auth::user()->hasRole('admin'))
			<div id="usersonline">
				@include(Theme::path('admin/helpers/users-online-short'))
			</div>
			<script type="text/javascript">
				$.fn.poller('add',{'id':'#usersonline', 'type':'template', 'func':'admin/helpers/users-online-short', 'value':'',  'ratio': '5'});
			</script>
		@endif
	</div>
	<div class="col-sm-9 col-md-9 col-md-offset-3 col-sm-offset-3 main">
		@include(Theme::path('notifications'))
		@yield('left-layout-content')
	</div>
  </div>
 </div>
@stop