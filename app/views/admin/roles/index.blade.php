@extends('admin.layouts.default')

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include('admin/navigation/users')
@stop

@section('left-layout-content')
	<div class="page-header clearfix">		
		<div class="pull-left"><h3>{{{ $title }}}</h3></div>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/roles/create') }}}" class="btn btn-small btn-info modalfy"><span class="glyphicon glyphicon-plus-sign"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include('admin/dt-loading')

	<div id="roles-container" class="dt-wrapper">
		<table id="roles" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th></th>
					<th class="col-md-6">{{{ Lang::get('admin/roles/table.name') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/roles/table.users') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/roles/table.created_at') }}}</th>
					<th class="col-md-2" >{{{ Lang::get('table.actions') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
@stop
@include('admin/left-layout')

@section('scripts')
<script type="text/javascript">
	dtLoad('#roles', 'roles/data', 'td:eq(1), th:eq(1)', 'td:eq(2), th:eq(2)');
</script>
@stop