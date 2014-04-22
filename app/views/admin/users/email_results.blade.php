@extends('admin.layouts.modal')

@section('styles')
@stop
@section('scripts')
@stop

@section('content')

@if($_results)
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4>Success</h4>
	{{{ $message }}}
</div>
@else
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4>Error</h4>
	{{{ $message }}}
</div>
@endif
{{ Form::reset(Lang::get('button.close'), array('class' => 'btn btn-primary', 'onclick'=>'parent.bootbox.hideAll()')); }} 

@stop