@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ Lang::get('admin/blogs/title.blog_management') }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/slugs'))
@stop

@section('left-layout-content')
	<div class="page-header clearfix">
		<div class="pull-left"><h3>{{{ Lang::get('admin/blogs/title.blog_management') }}}</h3></div>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/slugs/create') }}}" class="btn  btn-info modalfy"><span class="fa fa-plus"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include(Theme::path('admin/dt-loading'))

	<div id="blogs-container" class="dt-wrapper">
		<table id="blogs" class="table table-responsive table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th></th>
					<th class="col-md-6">{{{ Lang::get('admin/blogs/table.title') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
					<th class="col-md-3">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
					<th class="col-md-1">{{{ Lang::get('table.actions') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
@stop
@include(Theme::path('admin/layouts/sidebar-left'))

@section('scripts')
	<script src="{{{ asset('assets/js/jquery.dataTables.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/datatables.js') }}}"></script>
	<script type="text/javascript">
		dtLoad('#blogs', 'slugs/data', 'td:eq(1), th:eq(1)', 'td:eq(2), th:eq(2)', '', 'false', 'true',[null,null,null,null,{ "bSortable": false }]);
	</script>
@stop

@section('head-scripts')
	<script src="{{{ asset('assets/js/bootstrap-wysiwyg.js') }}}"></script>
@stop