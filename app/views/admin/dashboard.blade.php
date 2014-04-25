@extends('admin.layouts.default')

@section('styles')
	<link rel="stylesheet" href="{{{ asset('assets/css/simpleweather.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-colorselector.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.responsive.css') }}}"/>
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@stop
@section('sub-nav-settings')
	<li class="divider"></li>
	<li><a href="" onclick="localStorage.clear();"><span class="fa fa-trash-o fa-fw"></span> {{{ Lang::get('button.cleardashsettings') }}}</a></li>
@stop

@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
	<script src="{{{ asset('assets/js/bootstrap-colorselector.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.responsive.js') }}}"></script>
	<script type="text/javascript">
		/* dashboard */
		var localdata_position = JSON.parse(localStorage.getItem('dashboard.grid'));
		var localdata_colors = JSON.parse(localStorage.getItem('dashboard.colors'));
		var localdata_states = JSON.parse(localStorage.getItem('dashboard.states'));
		var localdata_titles = JSON.parse(localStorage.getItem('dashboard.titles'));
		fnCreateGridster('dashboard.grid', 'dashboard.colors', 'dashboard.states', 'dashboard.titles');

		/*  polling 
		
			- Add new polling results to function postPolling in the AdminDashboardController
		
			fnAddPoll(element to update, command for backend, delay[1,2,3,4etc]);

		*/

		fnAddPoll('#widget-usersonline .panel-body', 'users_online', '5');

		/* resize sparklines */
		$(window).bind('load resize', throttle(_resize_sparkline, 200));
	</script>
@stop

@section('content')
	<br>
	<div class="gridster">
		<ul>
			@include('admin/widgets/minigraph')
			@include('admin/widgets/features')
			@include('admin/widgets/usersonline')
			@include('admin/widgets/graphs')
			@include('admin/widgets/todo')
		</ul>
	</div>
@stop