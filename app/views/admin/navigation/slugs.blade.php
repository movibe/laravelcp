<ul class="nav nav-sidebar nav-pills nav-stacked">
	<li {{ (Request::is('admin/slugs') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/slugs') }}}"><span class="glyphicon glyphicon-list-alt"></span>  {{{ Lang::get('core.slugs') }}}</a></li>
	<li {{ (Request::is('admin/comments') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span>  {{{ Lang::get('core.comments') }}}</a></li>
</ul>
