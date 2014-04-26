<ul class="nav nav-sidebar nav-pills nav-stacked">
	<li{{ (Request::is('admin/settings*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/settings') }}}"><span class="fa fa-cog fa-fw"></span>  &nbsp; {{{ Lang::get('core.settings') }}}</a></li>
</ul>