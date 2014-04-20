@extends('admin.layouts.modal')

@section('styles')
	<link rel="stylesheet" href="{{{ asset('assets/css/summernote.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/summernote-bs3.css') }}}"/>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
@stop
@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {
	  $('.wysiwyg').summernote({
			height: 200,
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['insert', ['link']]
			]});
	});
	</script>
@stop

@section('content')
	{{ Form::open(array('class' => 'form-horizontal')) }}

		<p><input type="text" name="subject" placeholder="{{{ Lang::get('core.subject') }}}" style="width:100%" class="form-control"/></p>

		<p><textarea name="body" class="wysiwyg"></textarea></p>



		{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-danger', 'onclick'=>'parent.bootbox.hideAll()')); }} 
		{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')); }} 
		<span class="btn btn-default btn-file">
		   <span class="glyphicon glyphicon-paperclip"> </span> <input type="file" name="email_attachment" multiple>
		</span>
		{{ Form::submit(Lang::get('button.email'), array('class' => 'btn btn-success')); }} 
	{{ Form::close(); }}
@stop