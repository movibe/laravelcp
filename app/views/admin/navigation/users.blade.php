<ul class="nav nav-sidebar nav-pills nav-stacked">
	<li {{ (Request::is('admin/users') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span>  {{{ Lang::get('core.users') }}}</a></li>
	<li {{ (Request::is('admin/roles') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-warning-sign"></span>  {{{ Lang::get('core.roles') }}}</a></li>
</ul>
