@extends('admin.layouts.modal')

@section('styles')
@stop
@section('scripts')
@stop

@section('content')
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4>Success</h4>
	{{{ $message }}}
	</div>
{{ Form::reset(Lang::get('button.close'), array('class' => 'btn btn-danger', 'onclick'=>'parent.bootbox.hideAll()')); }} 

@stop