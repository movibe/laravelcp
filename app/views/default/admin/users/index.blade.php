@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/users'))

	<div class="panel panel-info">
	<div class="panel-heading">{{{ Lang::get('core.active') }}} {{{ Lang::get('core.users') }}} <span class="badge pull-right">{{ DB::table('users')->where('confirmed', '=', '1')->count() }} </span></div>
	<div class="panel-body">
	{{ Lava::PieChart('activeusers')->outputInto('activeusers') }}
	{{ Lava::div('100%', '') }}
	</div></div>
@stop

@section('left-layout-content')
	<div class="page-header clearfix">
		<h3 class="pull-left">{{{ $title }}}</h3>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info modalfy"><span class="fa fa-lg fa-plus-square"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include(Theme::path('admin/dt-loading'))

	<div id="users-container" class="dt-wrapper">
		<table id="users" class="table-responsive table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th></th>
					<th class="col-md-3">{{{ Lang::get('admin/users/table.username') }}}</th>
					<th class="col-md-3">{{{ Lang::get('admin/users/table.email') }}}</th>
					<th class="col-md-3">{{{ Lang::get('admin/users/table.roles') }}}</th>
					<th class="col-md-3">{{{ Lang::get('table.actions') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<div class="dt-pop-control pull-right">&nbsp;
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					{{{ Lang::get('table.actions') }}} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					@yield('users-massmenu')
					<li><a href="#" data-action="user/mass/email" data-method="modal"  data-table="users" class="dt-mass">{{{ Lang::get('button.email') }}}</a></li>
					<li class="divider"></li>
					<li><a href="#" data-action="user/mass/merge" data-method="post"  data-table="users" data-confirm="true" class="dt-mass">{{{ Lang::get('button.merge') }}}</a></li>
					<li class="divider"></li>
					<li><a href="#" data-action="user/mass" data-method="delete"  data-table="users" data-confirm="true"   class="dt-mass">{{{ Lang::get('button.delete') }}}</a></li>
				</ul>
			</div>
		</div>
	</div>
@stop
@include(Theme::path('admin/left-layout'))

@section('scripts')

<script type="text/javascript">
	dtLoad('#users', 'users/data', 'td:eq(1), th:eq(1)', 'td:eq(2), th:eq(2)');
</script>
@stop