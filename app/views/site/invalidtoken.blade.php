@extends('site.layouts.default')

@section('title')
{{{ Lang::get('site.permission_denied') }}} ::
@parent
@stop
@section('content')
<div class="page-header">
	<h3>{{{ Lang::get('site.no_permission') }}}</h3>
	{{{ Lang::get('site.no_permission_csrf') }}}
</div>
@stop