@extends(Theme::path('admin/layouts/default'))

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
		/* add user online polling */
		$.fn.poller('add',{'id':'#widget-usersonline .panel-body', 'type':'users_online', 'ratio': '5'});
	
		/* run gridster */
		$.fn.gridster.responsive();

		/* resize sparklines */
		$(window).bind('load resize', function(){
			throttle(_resize_sparkline({{ $minigraph_json }}), 200)
		});
	</script>
@stop

@section('content')
	<br>
	@yield('dashboard-pre')
	<div class="gridster">
		<ul>
			@yield('dashboard-widgets-pre')
			@foreach($widgets as $id=>$var)
				@include(Theme::path('admin/widgets/'.preg_replace('/.blade.php/i', '',$var->getRelativePathname())))
			@endforeach
			@yield('dashboard-widgets-post')
		</ul>
	</div>
	@yield('dashboard-post')
@stop