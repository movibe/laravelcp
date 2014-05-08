<div class="list-group" style="margin: 5px">
	<a href="{{{ URL::to('admin/slugs') }}}" class="list-group-item {{ (Request::is('admin/slugs') ? ' active' : '') }}">{{{ Lang::get('core.slugs') }}}</a>
	<a href="{{{ URL::to('admin/comments') }}}" class="list-group-item {{ (Request::is('admin/comments') ? ' active' : '') }}">{{{ Lang::get('core.comments') }}}</a>
</div>
<br/>