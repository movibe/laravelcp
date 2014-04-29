<ul class="nav nav-sidebar nav-pills nav-stacked">
	<li {{ (Request::is('admin/todos') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/todos') }}}"><span class="fa fa-lg fa-list-alt fa-fw"></span>  {{{ Lang::get('core.todos') }}}</a></li>
</ul>
