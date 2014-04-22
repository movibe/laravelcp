@extends('admin.layouts.modal')

@section('styles')
	<link rel="stylesheet" href="{{{ asset('assets/css/summernote.css') }}}"/>
	<link rel="stylesheet" href="{{{ asset('assets/css/summernote-bs3.css') }}}"/>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
@stop
@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>

	<script type="text/javascript">
	$('.template-dropdown a').on('click', function(e){
		e.preventDefault();   
		$('#email-template').val($(this).attr('href'));
		$('.email-template-tag').html($(this).html());

	});


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
@if (isset($user))
	{{ Form::open(array('url' => array('admin/users/' . $user->id . '/email'), 'class' => 'form-horizontal')) }}
@else
	{{ Form::open(array('url' => array('admin/user/mass/email'), 'class' => 'form-horizontal')) }}
@endif

	
	@if(isset($multi) && count($multi) > 0)
		<p>
			<select name="to[]" multiple style="width: 100%; height: 40px;" class="form-control">
				@foreach ($multi as $i=>$email)
					<option value="{{{ $i }}}" selected>{{{ $email }}}</option>
				@endforeach
			</select>		
		</p>
	@endif
		<p><input type="text" name="subject" placeholder="{{{ Lang::get('core.subject') }}}" style="width:100%" class="form-control"/></p>

		<p><textarea name="body" class="wysiwyg"></textarea></p>


		
		<div class="btn-group">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-danger', 'onclick'=>'parent.bootbox.hideAll()')); }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')); }} 
		</div>

		<div class="btn-group">
			<span class="btn btn-default btn-file">
			   <span class="glyphicon glyphicon-paperclip"> </span> <input type="file" name="email_attachment" multiple>
			</span>
			<div class="btn-group dropup">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="email-template-tag">Template</span>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu template-dropdown">
					<li><a href="emails.default">Default</a></li>
					@foreach($templates as $id=>$var)
						@if($var->getFilename() != 'default.blade.php')
						<li><a href="emails.{{{ str_replace(DIRECTORY_SEPARATOR, '.',rtrim($var->getRelativePathname(),'.blade.php')) }}}">{{{ str_replace(DIRECTORY_SEPARATOR, '.',rtrim($var->getRelativePathname(),'.blade.php')) }}}</a></li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
		<input type="hidden" id="email-template" name="template" value="emails.default"/>


		{{ Form::submit(Lang::get('button.send'), array('class' => 'btn btn-success')); }} 


	{{ Form::close(); }}
@stop