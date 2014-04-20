@extends('admin.layouts.default')

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include('admin/navigation/slugs')
@stop

@section('left-layout-content')
	<div class="page-header clearfix">
		<h3>{{{ $title }}}</h3>
	</div>

	@include('admin/dt-loading')

	<div class="dt-wrapper">
		<table id="comments" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th class="col-md-3">{{{ Lang::get('admin/comments/table.title') }}}</th>
					<th class="col-md-3">{{{ Lang::get('admin/blogs/table.post_id') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/users/table.username') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/comments/table.created_at') }}}</th>
					<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
				</tr>
			</thead>
		</table>
	</div>
@stop
@include('admin/left-layout')

@section('scripts')
<script type="text/javascript">
	dtLoad('#comments', 'comments/data', 'td:eq(2), th:eq(2)', 'td:eq(1), th:eq(1)');
</script>
@stop