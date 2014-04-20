@extends('admin.layouts.default')

@section('styles')
<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-colorselector.css') }}}"/>
<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.css') }}}"/>
<link rel="stylesheet" href="{{{ asset('assets/css/jquery.gridster.responsive.css') }}}"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@stop
@section('sub-nav-settings')
	<li><a href="" onclick="localStorage.clear();"><span class="glyphicon glyphicon-remove"></span> {{{ Lang::get('button.clearlocalsettings') }}}</a></li>
@stop

@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	<script src="{{{ asset('assets/js/bootstrap-colorselector.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.gridster.responsive.js') }}}"></script>
	<script type="text/javascript">

		var localdata_position = JSON.parse(localStorage.getItem('dashboard.grid'));
		var localdata_colors = JSON.parse(localStorage.getItem('dashboard.colors'));
		var localdata_states = JSON.parse(localStorage.getItem('dashboard.states'));
		var localdata_titles = JSON.parse(localStorage.getItem('dashboard.titles'));


		fnCreateGridster('dashboard.grid', 'dashboard.colors', 'dashboard.states', 'dashboard.titles');




fnAddPoll('#li4 .panel-body', 'users_online', '1');
fnAddPoll('logs', 'check_logs', '1');


/* call back from results */
function fnUpdateGrowler(id, args){
	$.each(args, function(i,value){
		$.bootstrapGrowl(value, { type: 'success' });
	});
}


	</script>
@stop

@section('content')
	<br>
	<div class="gridster">
		<ul>
			<li id="li1" data-row="1" data-col="1" data-sizex="1" data-sizey="5">
				<div class="panel panel-default">
				  <div class="panel-heading clearfix">
					  <span class="panel-title pull-left"><span class="glyphicon glyphicon-asterisk"></span> <span class="panel-title-text">Featuring</span></span>
					  @include('admin/widget-controls', array('id' => 'li1'))
				  </div>
				  <div class="panel-body ">
						<ul class="list-group">
							<li class="list-group-item">http://kevinkhill.github.io/LavaCharts/</li>
							<li class="list-group-item">https://github.com/Crinsane/LaravelShoppingcart</li>
							<li class="list-group-item">http://bootstrapper.aws.af.cm/components</li>
							<li class="list-group-item">maybe http://payum.forma-dev.com/documentation/0.8/Core/get-it-started</li>
							<li class="list-group-item">http://bootboxjs.com/documentation.html</li>
							<li class="list-group-item">https://github.com/Regulus343/ActivityLog</li>
						</ul>
				  </div>
				</div>			
			</li>
			<li id="li3" data-row="2" data-col="1" data-sizex="2" data-sizey="5">
				<div class="panel panel-default">
				  <div class="panel-heading clearfix">
					  <span class="panel-title pull-left"><span class="glyphicon glyphicon-signal"></span> <span class="panel-title-text">Graph Example</span></span>
					  @include('admin/widget-controls', array('id' => 'li3'))
				  </div>
				  <div class="panel-body" style="overflow: hidden">
						{{ Lava::LineChart('Stocks')->outputInto('stocks_div') }}
						{{ Lava::div('80%', '') }}
					</div>
				</div>			
			</li>
			<li id="li4" data-row="1" data-col="1" data-sizex="1" data-sizey="5">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						 <span class="panel-title pull-left"><span class="glyphicon glyphicon-user"></span> <span class="panel-title-text">{{{ Lang::get('core.users_online') }}}</span></span>
						@include('admin/widget-controls', array('id' => 'li4'))
					</div>
					<div class="panel-body">
						@include('admin/helpers/users-online')
					</div>
				</div>	
			</li>
		</ul>
	</div>
@stop