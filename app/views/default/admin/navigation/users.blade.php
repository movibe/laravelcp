<div class="list-group" style="margin: 5px">
	@if(Auth::user()->can("manage_users"))<a href="{{{ URL::to('admin/users') }}}" class="list-group-item {{ (Request::is('admin/users') ? ' active' : '') }}">{{{ Lang::get('core.users') }}}</a>@endif
	@if(Auth::user()->can("manage_roles"))<a href="{{{ URL::to('admin/roles') }}}" class="list-group-item {{ (Request::is('admin/roles') ? ' active' : '') }}">{{{ Lang::get('core.roles') }}}</a>@endif
</div>
<br/>