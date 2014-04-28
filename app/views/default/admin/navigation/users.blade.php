<ul class="nav nav-sidebar nav-pills nav-stacked">
	<li {{ (Request::is('admin/users') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="fa fa-lg fa-user fa-fw"></span>  {{{ Lang::get('core.users') }}}</a></li>
	<li {{ (Request::is('admin/roles') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="fa fa-lg fa-warning fa-fw"></span>  {{{ Lang::get('core.roles') }}}</a></li>
</ul>
