<div class="list-group" style="margin: 5px">
	<a href="{{{ URL::to('admin/settings') }}}" class="list-group-item {{ (Request::is('admin/settings*') ? ' active' : '') }}">{{{ Lang::get('core.settings') }}}</a>
</div>
<br/>