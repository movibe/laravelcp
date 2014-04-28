@extends(Theme::path('site/layouts/default'))

@section('title')
	{{{ Lang::get('site.sign_up') }}} ::
@parent
@stop

@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('site.sign_up') }}}</h1>
</div>
<h4> {{{ Lang::get('site.created_with') }}}</h4><div class="btn-group">
	@foreach ($providers as $provider)
		<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title=" {{{ Lang::get('site.created_with') }}} {{{ $provider }}}" class="confirm_terms btn btn-default" ><span style="font-size: 18px"  class="fa fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></span></a>
	@endforeach</div>
<br/>
<br/>
<h4> {{{ Lang::get('site.create_with_or') }}}</h4>


<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	{{ Form::honeypot('create_hp', 'create_hp_time') }}

    <fieldset>
		<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
			<div class="input-group">
			<input required class="form-control" placeholder="{{{ Lang::get('core.fullname') }}}" type="text" name="name" value="{{{ Input::old('name') }}}">
				<span class="input-group-addon"><span class="fa fa-fw fa-user"></span></span>
			</div>
			{{ $errors->first('name', '<span class="help-block">:message</span>') }}
		</div>
       <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
            <div class="input-group">
				<input required validate type="email" class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" name="email" id="email" value="{{{ Input::old('email') }}}">
				<span class="input-group-addon"><span class="fa fa-fw fa-envelope"></span></span>
			</div>
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
        </div>
        <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
			 <div class="input-group">
				<input pattern=".{3,}" required class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
				<span class="input-group-addon"><span class="fa fa-fw fa-lock"></span></span>
			</div>
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
        </div>
        <div class="form-group {{{ $errors->has('password_confirmation') ? 'has-error' : '' }}}">
			 <div class="input-group">
	          <input pattern=".{3,}" required class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
				<span class="input-group-addon"><span class="fa fa-fw fa-lock"></span></span>
			</div>
			{{ $errors->first('password_confirmation', '<span class="help-block">:message</span>') }}
        </div>
        <div class="form-group {{{ $errors->has('terms') ? 'has-error' : '' }}}">
			  <input required id="site_terms" type="checkbox" name="terms" checked> 
			  <label for="site_terms">{{ Lang::get('core.agree_tos') }}</label>
			  {{ $errors->first('terms', '<span class="help-block">:message</span>') }}
        </div>


        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>
    </fieldset>
</form>
<div id="site_tos" class="hide">
	<div class="inner_tos">
		@include(Theme::path('site/tos'))
	</div>
</div>

@stop

@section('styles')
	<style type="text/css">
		.inner_tos{ height: 250px; overflow: auto }
	</style>
@stop
@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.2.0/bootbox.min.js"></script>
	<script type="text/javascript">
		$(document).on("click", ".site_tos", function(e) {
			e.preventDefault();   
			bootbox.alert($('#site_tos').html());
		});
		$(document).on("click", ".confirm_terms", function(e) {
			if(!$('#site_terms').is(':checked')){
				bootbox.alert('{{{ Lang::get('core.must_agree_tos') }}}');
				e.preventDefault();   
				return false;
			}
		});
		$('a').tooltip();
	</script>
@stop
