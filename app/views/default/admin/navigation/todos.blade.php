<div class="list-group" style="margin: 5px">
	<a href="{{{ URL::to('admin/todos') }}}" class="list-group-item {{ (Request::is('admin/todos') ? ' active' : '') }}">{{{ Lang::get('core.todos') }}}</a>
</div>
<br/>