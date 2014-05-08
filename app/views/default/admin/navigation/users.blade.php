<div class="list-group" style="margin: 5px">
	<a href="{{{ URL::to('admin/users') }}}" class="list-group-item {{ (Request::is('admin/users') ? ' active' : '') }}">{{{ Lang::get('core.users') }}}</a>
	<a href="{{{ URL::to('admin/roles') }}}" class="list-group-item {{ (Request::is('admin/roles') ? ' active' : '') }}">{{{ Lang::get('core.roles') }}}</a>
</div>
<br/>