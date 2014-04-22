@extends('admin.layouts.modal')

@section('styles')
	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
	<style type="text/css"> 
		#editor {
			height: 200px;
			overflow: auto;
		}
	</style>
@stop

@section('scripts')
	<script src="//cdn.jsdelivr.net/jquery.hotkeys/0.8b/jquery.hotkeys.min.js"></script>
	<script src="{{{ asset('assets/js/bootstrap-wysiwyg.js') }}}"></script>
	<script src="{{{ asset('assets/js/bootstrap-wysiwyg-start.js') }}}"></script>

	<script type="text/javascript">
		$('.template-dropdown a').on('click', function(e){
			e.preventDefault();   
			$('#email-template').val($(this).attr('href'));
			$('.email-template-tag').html($(this).html());
		});
	</script>
@stop


@section('content')

@if (isset($user))
	{{ Form::open(array('url' => array('admin/users/' . $user->id . '/email'), 'class' => 'form-horizontal', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html());")) }}
@else
	{{ Form::open(array('url' => array('admin/user/mass/email'), 'class' => 'form-horizontal', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html());")) }}
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
		<p>
			<input type="text" name="subject" placeholder="{{{ Lang::get('core.subject') }}}" style="width:100%" class="form-control"/>
		</p>

		<p>
			@include('wysiwyg')
		</p>



		<textarea class="hide" id="wysiwyg-body" name="body"></textarea>


		<p>
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
		</p>


	{{ Form::close(); }}
@stop