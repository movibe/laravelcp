@extends(Theme::path('admin/layouts/default'))

@section('styles')
	<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-colorselector.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.responsive.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-editable.css') }}}"/>
@stop
@section('sub-nav-settings')
	<li class="divider"></li>
	<li><a href="{{{ URL::to('admin') }}}" onclick="localStorage.clear();"><span class="fa fa-trash-o fa-fw"></span> {{{ Lang::get('button.cleardashsettings') }}}</a></li>
@stop

@section('head-scripts')
	<script src="{{{ asset('assets/js/moment.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}}"></script>
@stop

@section('scripts')
	<script src="{{{ asset('assets/js/bootstrap-editable.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.sparkline.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/bootstrap-colorselector.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.responsive.js') }}}"></script>
	<script type="text/javascript">
		/* add user online polling */
		$.fn.poller('add',{'id':'#widget-usersonline .panel-body', 'type':'template', 'func':'admin/helpers/users-online', 'value':'10',  'ratio': '5'});

		/* run gridster */
		$.fn.gridster.responsive();

		/* resize sparklines */
		function _resize_sparkline(data){
			if( $( window ).width() > 760){
				var _w=(($( window ).width()/4)/6)-9;
			} else 	var _w=(($( window ).width()/2)/6)-11;

			$.each(data, function(i,value){ 
				$('#spark_'+ i).sparkline(value.data.reverse(), { enableTagOptions: true , barWidth: _w, barSpacing: '6' });
			});
		}

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