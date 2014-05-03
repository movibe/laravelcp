@extends(Theme::path('admin/layouts/modal'))

@section('styles')
	<style type="text/css"> 
		#editor {
			height: 200px;
			overflow: auto;
		}
	</style>
@stop

@section('scripts')
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
	{{ Form::open(array('url' => array('admin/users/' . $user->id . '/email'), 'class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html());")) }}
@else
	{{ Form::open(array('url' => array('admin/user/mass/email'), 'class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html());")) }}
@endif

	@if(isset($multi) && count($multi) > 0)
	<div class="form-group">
		<div class="col-md-12">
		
			<select name="to[]" multiple style="width: 100%; height: 40px;" class="form-control">
				@foreach ($multi as $i=>$email)
					<option value="{{{ $i }}}" selected>{{{ $email }}}</option>
				@endforeach
			</select>		
		</div>
	</div>
	@endif
	<div class="form-group">
		<div class="col-md-12">
			<input type="text" name="subject" placeholder="{{{ Lang::get('core.subject') }}}" style="width:100%" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			@include(Theme::path('wysiwyg'))
		</div>
	</div>
	<div class="modal-footer">
			<div class="pull-left">
				{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")); }} &nbsp;
				{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')); }} 
			</div>

			<div class="pull-right">
					<div class="btn btn-responsive btn-default btn-file">
					   <span class="fa fa-lg fa-paperclip"> </span> <input type="file" name="email_attachment" multiple>
					</div>
					<div class="btn-group dropup">
						<button type="button" class="btn-responsive btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="email-template-tag">Template</span>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu template-dropdown">
							<li><a href="emails.default">Default</a></li>
							@foreach($templates as $id=>$var)
								@if($var->getFilename() != 'default.blade.php')
								<li><a href="emails.{{{ str_replace(DIRECTORY_SEPARATOR, '.',preg_replace('/.blade.php/i', '',$var->getRelativePathname())) }}}">{{{ str_replace(DIRECTORY_SEPARATOR, '.',rtrim($var->getRelativePathname(),'.blade.php')) }}}</a></li>
								@endif
							@endforeach
						</ul>
					</div>
				{{ Form::submit(Lang::get('button.send'), array('class' => 'btn-responsive btn btn-success')); }} 
			</div>

			<input type="hidden" id="email-template" name="template" value="emails.default"/>
			<textarea class="hide" id="wysiwyg-body" name="body"></textarea>

	</div>
	<script type="text/javascript">
		initToolbarBootstrapBindings();  
		$('#editor').wysiwyg({ fileUploadError: showErrorAlert, hotKeys: {}} );
	</script>

	{{ Form::close(); }}
@stop