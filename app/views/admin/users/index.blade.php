@extends('admin.layouts.default')

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include('admin/navigation/users')

	<div class="panel panel-info">
	<div class="panel-heading">{{{ Lang::get('core.active') }}} {{{ Lang::get('core.users') }}} <span class="badge pull-right">1</span></div>
	<div class="panel-body">
	{{ Lava::PieChart('activeusers')->outputInto('activeusers') }}
	{{ Lava::div('100%', '') }}
	</div></div>
@stop

@section('left-layout-content')
	<div class="page-header clearfix">
		<h3 class="pull-left">{{{ $title }}}</h3>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info modalfy"><span class="glyphicon glyphicon-plus-sign"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include('admin/dt-loading')

	<div class="dt-wrapper">
		<table id="users" class="table-responsive table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>{{{ Lang::get('admin/users/table.username') }}}</th>
					<th>{{{ Lang::get('admin/users/table.email') }}}</th>
					<th>{{{ Lang::get('admin/users/table.roles') }}}</th>
					<th>{{{ Lang::get('table.actions') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<div class="dt-pop-control pull-right">
			<div class="btn-group">
				<button data-action="user/mass/delete" data-method="delete" type="button" class="dt-mass btn btn-danger dropdown-toggle">{{{ Lang::get('button.delete') }}}</button>
			</div>
		</div>
	</div>
@stop
@include('admin/left-layout')

@section('scripts')
<script type="text/javascript">
	dtLoad('#users', 'users/data', 'td:eq(2), th:eq(2)', 'td:eq(1), th:eq(1)');
</script>
@stop