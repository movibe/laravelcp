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
	<li><a href="" onclick="localStorage.clear();"><span class="glyphicon glyphicon-remove"></span> {{{ Lang::get('button.cleardashsettings') }}}</a></li>
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
		fnAddPoll('logs', 'check_logs', '10');

		/* call back from results */
		function fnUpdateGrowler(id, args){
			$.each(args, function(i,value){
				$.bootstrapGrowl(value, { type: 'success' });
			});
		}

		/* resize sparklines */
		$(window).bind('load resize', throttle(_resize_sparkline, 200));
	</script>
@stop

@section('content')
	<br>
	<div class="gridster">
		<ul>
			<li id="widget-minigraphs" data-row="1" data-col="1" data-sizex="2" data-sizey="2" data-max-sizex="2" data-min-sizex="2" data-max-sizey="2"  data-min-sizey="2">
				<div class="container-fluid">
					<div class="row">
						<div class="pull-left col-xs-6  col-sm-3 col-md-3 panel-default-sm">
							<div class="panel panel-default ">
								<div class="panel-body panel-body-full panel-handel">
									<span class="sparklines"  sparkWidth="100%" sparkHeight="60" sparkType="bar" sparkBarColor="green"></span>
									<div class="datas-text">12,000 visitors/day</div>
								</div>
							</div>
						</div>
						<div class="pull-left hidden-xs  col-sm-3 col-md-3 panel-default-sm">
							<div class="panel panel-default">
								<div class="panel-body panel-body-full panel-handel">
									<span class="sparklines"  sparkHeight="60" sparkType="bar" sparkBarColor="lightblue"></span>
									<div class="datas-text">2,000 unique/day</div>
								</div>
							</div>
						</div>
						<div class="pull-left col-xs-6 col-sm-3 col-md-3 panel-default-sm">
							<div class="panel panel-default">
								<div class="panel-body panel-body-full panel-handel">
									<span class="sparklines"  sparkHeight="60" sparkType="bar" sparkBarColor="yellow"></span>
									<div class="datas-text">25,000 hits/day</div>
								</div>
							</div>
						</div>
						<div class="pull-left hidden-xs col-sm-3  col-md-3 panel-default-sm">
							<div class="panel panel-default">
								<div class="panel-body panel-body-full  panel-handel">
									<div class="sparklines" sparkHeight="60" sparkType="bar" sparkBarColor="orange"></div>
									<div class="datas-text">2,000 beers/day</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>




			<li id="widget-features" data-row="2" data-col="1" data-sizex="1" data-sizey="5">
				<div class="panel panel-default">
				  <div class="panel-heading clearfix">
					  <span class="panel-title pull-left"><span class="glyphicon glyphicon-asterisk"></span> <span class="panel-title-text">Featuring</span></span>
					  @include('admin/widget-controls', array('id' => 'widget-features'))
				  </div>
				  <div class="panel-body ">
						<ul class="list-group">
							<li class="list-group-item">http://kevinkhill.github.io/LavaCharts/</li>
							<li class="list-group-item">https://github.com/Crinsane/LaravelShoppingcart</li>
							<!--<li class="list-group-item">maybe http://payum.forma-dev.com/documentation/0.8/Core/get-it-started</li>-->
							<li class="list-group-item">http://bootboxjs.com/documentation.html</li>
							<li class="list-group-item">https://github.com/Regulus343/ActivityLog</li>
						</ul>
				  </div>
				</div>			
			</li>

			<li id="widget-usersonline" data-row="2" data-col="1" data-sizex="1" data-sizey="5">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						 <span class="panel-title pull-left"><span class="glyphicon glyphicon-user"></span> <span class="panel-title-text">{{{ Lang::get('core.users_online') }}}</span></span>
						@include('admin/widget-controls', array('id' => 'widget-usersonline'))
					</div>
					<div class="panel-body">
						@include('admin/helpers/users-online')
					</div>
				</div>	
			</li>


			<li id="widget-graph" data-row="3" data-col="1" data-sizex="2" data-sizey="5">
				<div class="panel panel-default">
				  <div class="panel-heading clearfix">
					  <span class="panel-title pull-left"><span class="glyphicon glyphicon-signal"></span> <span class="panel-title-text">Graph Example</span></span>
					  @include('admin/widget-controls', array('id' => 'widget-graph'))
				  </div>
				  <div class="panel-body" style="overflow: hidden">
						{{ Lava::LineChart('Stocks')->outputInto('stocks_div') }}
						{{ Lava::div('80%', '') }}
					</div>
				</div>			
			</li>

			<li id="widget-todo" data-row="4" data-col="1" data-sizex="1" data-sizey="5">
				<div class="panel panel-default">
				  <div class="panel-heading clearfix">
					  <span class="panel-title pull-left"><span class="glyphicon glyphicon-asterisk"></span> <span class="panel-title-text">To-do</span></span>
					  @include('admin/widget-controls', array('id' => 'widget-todo'))
						<ul class="nav nav-tabs pull-right hidden-xs  hidden-sm">
						  <li class="active"><a href="#home" data-toggle="tab">Pending</a></li>
						  <li><a href="#profile" data-toggle="tab">Completed</a></li>
						</ul>
				  </div>
				  <div class="panel-body ">
					<div class="tab-content">
						<div class="tab-pane active" id="home">
							<ul class="list-group">
								<li class="list-group-item">add cancel client feature, button client can click to cancel the account, insert to cancellation db, process later with queue</li>
								<li class="list-group-item">siwtch forms to use http://anahkiasen.github.io/former/ so they can have frontend validation</li>
							</ul>
						</div>
						<div class="tab-pane" id="profile">...</div>
					</div>
				  </div>
				</div>			
			</li>
		</ul>
	</div>

@stop