<li id="widget-todos" data-row="4" data-col="1" data-sizex="1" data-sizey="5">
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<span class="panel-title pull-left"><span class="fa fa-lg fa-list-alt"></span> <span class="panel-title-text">{{{ Lang::get('core.todos') }}}</span></span>
			&nbsp; &nbsp; <a href="{{{ URL::to('admin/todos/create') }}}" class="btn btn-xs btn-info modalfy hidden-xs hidden-s"><span class="fa fa-sm fa-plus"></span> {{{ Lang::get('button.create') }}}</a>
			@include(Theme::path('admin/widget-controls'), array('id' => 'widget-todos'))
		</div>
		<div class="panel-body">
			@include(Theme::path('admin/helpers/todos'), array('type' => 'widget'))
		</div>
	</div>	
</li>