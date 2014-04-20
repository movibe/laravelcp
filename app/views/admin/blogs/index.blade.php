@extends('admin.layouts.default')

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include('admin/navigation/slugs')
@stop

@section('left-layout-content')
	<div class="page-header clearfix">
		<div class="pull-left"><h3>{{{ $title }}}</h3></div>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/slugs/create') }}}" class="btn btn-small btn-info modalfy"><span class="glyphicon glyphicon-plus-sign"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include('admin/dt-loading')

	<div class="dt-wrapper">
		<table id="blogs" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th class="col-md-4">{{{ Lang::get('admin/blogs/table.title') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
					<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
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
	dtLoad('#blogs', 'slugs/data', 'td:eq(2), th:eq(2)', 'td:eq(1), th:eq(1)');
</script>
@stop