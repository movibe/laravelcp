@extends(Theme::path('site/layouts/default'))

@section('title')
{{{ Lang::get('site.permission_denied') }}} ::
@parent
@stop
@section('content')
<div class="page-header">
	<h3>{{{ Lang::get('site.no_longer_active') }}}</h3>
</div>
{{{ Lang::get('site.no_longer_active_reason') }}}
@stop
