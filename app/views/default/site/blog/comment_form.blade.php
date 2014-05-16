<div class="row">
<form method="post" action="{{{ URL::to($post->slug) }}}">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
	{{ Form::honeypot('comment_hp', 'comment_time') }}

	<div class="form-group">
		<div class="col-md-12">
			<textarea required placeholder="{{{ Lang::get('site.add_comment') }}}" class="col-md-12 form-control" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-12">
			<input type="submit" class="btn btn-default" id="submit" value="{{{ Lang::get('button.submit') }}}" />
		</div>
	</div>
</form>
</div>
@if($errors->has())
<div class="alert alert-danger alert-block">
<ul>
@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
