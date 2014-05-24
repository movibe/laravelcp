@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ Lang::get('admin/roles/title.role_management') }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/users'))
@stop

@section('left-layout-content')
	<div class="page-header clearfix">		
		<div class="pull-left"><h3>{{{ Lang::get('admin/roles/title.role_management')  }}}</h3></div>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/roles/create') }}}" class="btn  btn-info modalfy"><span class="fa fa-plus"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include(Theme::path('admin/dt-loading'))

	<div id="roles-container" class="dt-wrapper">
		<table id="roles" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th></th>
					<th class="col-md-6">{{{ Lang::get('admin/roles/table.name') }}}</th>
					<th class="col-md-2">{{{ Lang::get('admin/roles/table.users') }}}</th>
					<th class="col-md-3">{{{ Lang::get('admin/roles/table.created_at') }}}</th>
					<th style="col-md-1">{{{ Lang::get('table.actions') }}}</th>
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
		dtLoad('#roles', 'roles/data', 'td:eq(1), th:eq(1)', 'td:eq(2), th:eq(2)', '', 'false', 'true',[null,null,null,null,{ "bSortable": false }]);
	</script>
@stop