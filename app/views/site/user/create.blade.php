@extends('site.layouts.default')

{{-- Web site Title --}}
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
		<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title=" {{{ Lang::get('site.created_with') }}} {{{ $provider }}}" class="btn btn-default" ><i style="font-size: 18px"  class="fa fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></i></a>
	@endforeach</div>
<br/>
<br/>
<h4> {{{ Lang::get('site.create_with_or') }}}</h4>


<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	{{ Form::honeypot('create_hp', 'create_hp_time') }}

    <fieldset>
		<div class="form-group">
			<div class="input-group">
			<input class="form-control" placeholder="{{{ Lang::get('core.fullname') }}}" type="text" name="name" value="{{{ Input::old('name') }}}">
				<span class="input-group-addon"><span class="fa fa-fw fa-user"></span></span>
			</div>
		</div>
       <div class="form-group">
            <div class="input-group">
				<input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
				<span class="input-group-addon"><span class="fa fa-fw fa-envelope"></span></span>
			</div>
        </div>
        <div class="form-group">
			 <div class="input-group">
				<input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
				<span class="input-group-addon"><span class="fa fa-fw fa-lock"></span></span>
			</div>
        </div>
        <div class="form-group">
			 <div class="input-group">
	          <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
				<span class="input-group-addon"><span class="fa fa-fw fa-lock"></span></span>
			</div>
        </div>

        @if ( Session::get('error') )
            <div class="alert alert-error alert-danger">
                @if ( is_array(Session::get('error')) )
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
@stop

@section('scripts')
	<script type="text/javascript">
		$('a').tooltip();
	</script>
@stop
