@extends('site.layouts.default')

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
{{ Form::open(array('class' => 'form-horizontal form-ajax')) }}
    <fieldset>
        <div class="form-group">
            <!--<label class="col-md-2 control-label" for="email">{{ Lang::get('confide::confide.e_mail') }}</label>-->
            <div class="col-md-10">
               <div class="input-group">
                                 <input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide::confide.e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}"><span class="input-group-addon"><span class="fa fa-envelope"></span>
                                </span></div>
            </div>
        </div>
        <div class="form-group">
           <!-- <label class="col-md-2 control-label" for="password">
                {{ Lang::get('confide::confide.password') }}
            </label>-->
            <div class="col-md-10">

			<div class="input-group">
				<input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide::confide.password') }}" type="password" name="password" id="password">
				  <span class="input-group-btn">
					 <a class="btn btn-default" href="forgot">{{ Lang::get('button.reset') }}</a>
				  </span>
			</div>
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

				<button tabindex="3" type="submit" class="btn btn-primary">{{{ Lang::get('user/user.login') }}}</button>
or
				<div class="btn-group">
				@foreach ($providers as $provider)
						<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title="Login with {{{ $provider }}}" class="btn btn-default" ><i style="font-size: 18px" class="fa fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></i></a>
				@endforeach</div>

                
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
