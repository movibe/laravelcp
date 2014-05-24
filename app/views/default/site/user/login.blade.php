@extends(Theme::path('site/layouts/default'))

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('user/user.login') }}}</h1>
</div>

{{ Form::open_horizontal() }}

    <fieldset>

		{{ Form::input_group('email', 'email', '', Input::old('email'), $errors, array('maxlength'=>'254','required'=>'required', 'placeholder'=>Lang::get('confide::confide.e_mail')), '', false,'', 'fa fa-fw fa-envelope') }} 

		{{ Form::input_group('password', 'password', '', '', $errors, array('required'=>'required', 'placeholder'=>Lang::get('confide::confide.password')), '', false,'','','<a class="btn btn-default" href="forgot">'. Lang::get('button.reset') .'</a>') }} 

		{{ Form::checkbox_group('remember', Lang::get('confide::confide.login.remember'), '1', '', $errors, '', '',false) }}

        <div class="form-group">
            <div class=" col-md-12">
				<button tabindex="3" type="submit" class="btn btn-primary">{{{ Lang::get('user/user.login') }}}</button>
				@if(count($providers) > 0)
					{{ Lang::get('core.or') }}
					<div class="btn-group">
					@foreach ($providers as $provider)
							<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title="{{ Lang::get('core.loginwith') }} {{{ $provider }}}" class="btn btn-default" ><span class="fa fa-lg fa-fw fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></span></a>
					@endforeach</div>
				@endif
            </div>
        </div>
    </fieldset>

{{ Form::close() }}

@stop

@section('scripts')
	<script type="text/javascript">
		$('a').tooltip();
	</script>
@stop