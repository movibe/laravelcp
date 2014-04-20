@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
Permission Denied ::
@parent
@stop
@section('content')
<div class="page-header">
	<h3>Your account is no longer active.</h3>
	If you think this is an error please contact the sites administrator.
</div>
@stop
