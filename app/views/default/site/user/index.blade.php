@extends(Theme::path('site/layouts/default'))

@section('title')
{{{ Lang::get('site.your_account') }}} {{{ Lang::get('user/user.settings') }}} ::
@parent
@stop

@section('content')
<div class="page-header">
	<h3>{{{ Lang::get('site.your_account') }}} {{{ Lang::get('user/user.settings') }}}</h3>
</div>

<ul class="nav nav-tabs">
  <li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('user/user.settings') }}}</a></li>
  <li><a href="#tab-profile" data-toggle="tab">{{{ Lang::get('site.profile') }}}</a></li>
</ul>
<br/>
{{ Form::open(array('autocomplete' => 'off','url' => URL::to('user/' . $user->id . '/edit'), 'class' => 'form-horizontal')) }}
<div class="tab-content">
	<div class="tab-pane active" id="tab-general">
		<div class="form-group {{{ $errors->has('displayname') ? 'has-error' : '' }}}">
			<label class="col-md-2 control-label" for="displayname">{{{ Lang::get('core.fullname') }}}</label>
			<div class="col-md-10">
				<input required class="form-control" type="text" name="displayname" id="displayname" value="{{{ Input::old('displayname', $user->displayname) }}}" />
				{{ $errors->first('displayname', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
			<label class="col-md-2 control-label" for="email">{{{ Lang::get('core.email') }}}</label>
			<div class="col-md-10">
				<input required validate class="form-control" type="email" name="email" id="email" value="{{{ Input::old('email', $user->email) }}}" />
				{{ $errors->first('email', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
			<label class="col-md-2 control-label" for="password">{{{ Lang::get('core.password') }}}</label>
			<div class="col-md-10">
				<input class="form-control" type="password" name="password" id="password" value="" />
				{{ $errors->first('password', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group {{{ $errors->has('password_confirmation') ? 'has-error' : '' }}}">
			<label class="col-md-2 control-label" for="password_confirmation">{{{ Lang::get('core.password') }}} {{{ Lang::get('core.confirm') }}}</label>
			<div class="col-md-10">
				<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
				{{ $errors->first('password_confirmation', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success">{{{ Lang::get('button.update') }}}</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				@if($user->cancelled)
					<a href="{{ URL::to('user/' . $user->id . '/cancel/disable') }}" class="btn btn-info">{{{ Lang::get('site.remove_cancel') }}}</a>
				@else
					<div class="input-group-btn">
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">{{{ Lang::get('site.cancel_acct') }}} <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a class="btn-cancel" href="{{ URL::to('user/' . $user->id . '/cancel/now') }}">{{{ Lang::get('site.now') }}}</a></li>
							<li><a class="btn-cancel" href="{{ URL::to('user/' . $user->id . '/cancel/later') }}">{{{ Lang::get('site.infift') }}}</a></li>
							<li><a class="btn-cancel" href="{{ URL::to('user/' . $user->id . '/cancel/tomorrow') }}">{{{ Lang::get('site.tmr') }}}</a></li>
						</ul>
					</div>
			  @endif
			</div>
		</div>
    </div>
    <div class="tab-pane" id="tab-profile">
		<ul class="nav nav-pills">
				<li ><a href="#tab-create" data-toggle="tab"><span class="fa fa-plus-square"></span>  {{{ Lang::get('button.create') }}}</a></li>
				@foreach($profiles as $index=>$pro)
					<li @if ($index == 0)class="active"@endif><a href="#tab-{{{$pro->id}}}" data-toggle="tab" id="tab-c{{{$pro->id}}}">@if ($pro->title){{$pro->title}}@elseif($index == 0)Default @else#{{{$index}}}@endif</a></li>
				@endforeach
		</ul>
		<br/>
		<div class="tab-content">
			<div class="tab-pane" id="tab-create">
				@include(Theme::path('admin/users/profiles'))
			</div>

			@foreach($profiles as $index=>$profile)
				<div class="tab-pane @if (isset($index) && $index == 0)active@endif" id="tab-@if(isset($profile)){{{$profile->id}}}@endif">
					@include(Theme::path('site/user/profiles'))
				</div>
			@endforeach
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success">{{{ Lang::get('button.update') }}}</button>
			</div>
		</div>
	</div>
</div>
{{ Form::close(); }}

@stop
@section('scripts')
	<script type="text/javascript">
		$('.btn-cancel').on('click', function(e){
			e.preventDefault();    
			var link=$(this).attr('href');
			bootbox.confirm('{{{ Lang::get('site.areyousure') }}}', function(result) {
				if(result) window.location=link;
			});
		});
	</script>
@stop