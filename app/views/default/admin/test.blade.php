@section('main-nav-post')
	<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="fa fa-warning fa-fw"></span> &nbsp; {{{ Lang::get('Roles') }}}</a></li>
@stop