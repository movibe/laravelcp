@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ Lang::get('core.todos') }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/todos'))
@stop

@section('left-layout-content')
	<div class="page-header clearfix">		
		<div class="pull-left"><h3>{{{ Lang::get('core.todos') }}}</h3></div>
		<div class="pull-right">
			<a href="{{{ URL::to('admin/todos/create') }}}" class="btn btn-small btn-info modalfy"><span class="fa fa-lg fa-plus-square"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</div>

	@include(Theme::path('admin/helpers/todos'))



@stop
@include(Theme::path('admin/left-layout'))

