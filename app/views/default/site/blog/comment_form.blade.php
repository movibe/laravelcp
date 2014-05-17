{{ Form::open_horizontal(array('url' => URL::to($post->slug))) }}
	{{ Form::honeypot('create_hp', 'comment_time') }}
   
	<fieldset>

		{{ Form::textarea_group('comment', '', Request::old('comment'), $errors, array('placeholder' => Lang::get('site.add_comment'), 'required'=>'required'), '', false) }} 
	
		{{ Form::submit_group(array('submit_title'=>Lang::get('button.submit')),'',false) }}

    </fieldset>

{{ Form::close() }}

@if($errors->has())
	<div class="alert alert-danger alert-block">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif