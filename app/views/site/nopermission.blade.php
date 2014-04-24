@extends('site.layouts.default')

@section('title')
{{{ Lang::get('site.permission_denied') }}} ::
@parent
@stop
@section('content')
<div class="page-header">
	@if (!Auth::user())
		<h3>{{{ Lang::get('site.no_permission') }}}</h3>
		{{ Lang::get('site.login_link', array('link' => URL::to('user/login'))) }}
	@else
		<h3>{{{ Lang::get('site.no_permission') }}}</h3>
	@endif

</div>
@stop
