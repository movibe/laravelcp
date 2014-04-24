@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.register') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>Signup</h1>
</div>
<h4>Create an account with:</h4><div class="btn-group">
				@foreach ($providers as $provider)
						<a href="{{ URL::to('user/login/'.strtolower($provider)) }}" title="Login with {{{ $provider }}}" class="btn btn-default" ><i style="font-size: 18px"  class="fa fa-{{ preg_replace('/google/i','google-plus',strtolower($provider)) }}-square"></i></a>
				@endforeach</div>
<br/>
<br/>
<h4>Or create a new account:</h4>
{{ Confide::makeSignupForm()->render() }}



<br/>
<br/>
<br/>
<br/>
<br/>
@stop

@section('scripts')
	<script type="text/javascript">
		$('a').tooltip();
	</script>
@stop
