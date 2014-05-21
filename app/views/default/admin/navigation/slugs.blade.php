<div class="list-group" style="margin: 5px">
	@if(Auth::user()->can("manage_blogs"))<a href="{{{ URL::to('admin/slugs') }}}" class="list-group-item {{ (Request::is('admin/slugs') ? ' active' : '') }}">{{{ Lang::get('core.slugs') }}}</a>@endif
	@if(Auth::user()->can("manage_comments"))<a href="{{{ URL::to('admin/comments') }}}" class="list-group-item {{ (Request::is('admin/comments') ? ' active' : '') }}">{{{ Lang::get('core.comments') }}}</a>@endif
</div>
<br/>