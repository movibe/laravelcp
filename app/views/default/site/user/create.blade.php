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
<h4>{{{ Lang::get('site.create_with_or') }}}</h4>

{{ Form::open_horizontal(array('url' => (Confide::checkAction('UserController@store')) ?: URL::to('user'))) }}
	{{ Form::honeypot('create_hp', 'create_hp_time') }}

    <fieldset>

		{{ Form::input_group('text', 'displayname', '', Input::old('displayname'), $errors, array('required'=>'required', 'placeholder'=>Lang::get('core.fullname')), '', false,'', 'fa fa-fw fa-user') }} 

		{{ Form::input_group('email', 'email', '', Input::old('email'), $errors, array('required'=>'required', 'placeholder'=>Lang::get('confide::confide.e_mail')), '', false,'', 'fa fa-fw fa-envelope') }} 
		
		{{ Form::input_group('password', 'password', '', '', $errors, array('pattern' => '.{3,}', 'required'=>'required', 'placeholder'=>Lang::get('confide::confide.password')), '', false,'', 'fa fa-fw fa-lock') }} 

		{{ Form::input_group('password', 'password_confirmation', '', '', $errors, array('pattern' => '.{3,}', 'required'=>'required', 'placeholder'=>Lang::get('confide::confide.password_confirmation')), '', false,'', 'fa fa-fw fa-lock') }} 

		{{ Form::checkbox_group('terms', Lang::get('core.agree_tos'), '1', '', $errors, array('id'=>'site_terms','required'=>'required','checked'=>'checked'), '',false) }}

		{{ Form::submit_group(array('submit_title'=>Lang::get('confide::confide.signup.submit')),'',false) }}

    </fieldset>

{{ Form::close() }}

<div id="site_tos" class="hide">
	<div class="inner_tos">
		@include(Theme::path('site/tos'))
	</div>
</div>

@stop

@section('styles')
		.inner_tos{ height: 250px; overflow: auto }
@stop
@section('scripts')
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