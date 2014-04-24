@extends('site.layouts.default')

@section('title')
Permission Denied ::
@parent
@stop
@section('content')
<div class="page-header">
	<h3>You do not have permission to access this page.</h3>
	There was a problem with your security token, please try again.
</div>
@stop
