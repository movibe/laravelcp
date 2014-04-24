@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<div class="page-header">
	<h1>Login into your account</h1>
</div>
<form class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <fieldset>
        <div class="form-group">
            <!--<label class="col-md-2 control-label" for="email">{{ Lang::get('confide::confide.e_mail') }}</label>-->
            <div class="col-md-10">
                <input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide::confide.e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
            </div>
        </div>
        <div class="form-group">
           <!-- <label class="col-md-2 control-label" for="password">
                {{ Lang::get('confide::confide.password') }}
            </label>-->
            <div class="col-md-10">
                <input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide::confide.password') }}" type="password" name="password" id="password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <div class="checkbox">
                    <label for="remember">{{ Lang::get('confide::confide.login.remember') }}
                        <input type="hidden" name="remember" value="0">
                        <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">

				<button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide::confide.login.submit') }}</button>
or
				<div class="btn-group">
				@foreach ($providers as $provider)
						<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title="Login with {{{ $provider }}}" class="btn btn-default" ><i style="font-size: 18px" class="fa fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></i></a>
				@endforeach</div>

                <a class="pull-right btn btn-default" href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
            </div>
        </div>
    </fieldset>
</form>

@stop

@section('scripts')
	<script type="text/javascript">
		$('a').tooltip();
	</script>
@stop
