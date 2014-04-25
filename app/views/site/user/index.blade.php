@extends('site.layouts.default')

@section('title')
{{{ Lang::get('user/user.settings') }}} ::
@parent
@stop


@section('content')
<div class="page-header">
	<h3>{{{ Lang::get('user/user.settings') }}}</h3>
</div>
{{ Form::open(array('class' => 'form-horizontal')) }}
    <div class="tab-pane active" id="tab-general">
        <div class="form-group {{{ $errors->has('displayname') ? 'error' : '' }}}">
            <label class="col-md-2 control-label" for="displayname">{{{ Lang::get('core.fullname') }}}</label>
            <div class="col-md-10">
                <input class="form-control" type="text" name="displayname" id="username" value="{{{ Input::old('displayname', $user->displayname) }}}" />
                {{ $errors->first('displayname', '<span class="help-inline">:message</span>') }}
            </div>
        </div>

        <div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
            <label class="col-md-2 control-label" for="email">{{{ Lang::get('core.email') }}}</label>
            <div class="col-md-10">
                <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', $user->email) }}}" />
                {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
            </div>
        </div>

        <div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
            <label class="col-md-2 control-label" for="password">{{{ Lang::get('core.password') }}}</label>
            <div class="col-md-10">
                <input class="form-control" type="password" name="password" id="password" value="" />
                {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
            </div>
        </div>

        <div class="form-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
            <label class="col-md-2 control-label" for="password_confirmation">{{{ Lang::get('core.password') }}} {{{ Lang::get('core.confirm') }}}</label>
            <div class="col-md-10">
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
                {{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
    </div>

	<div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-success">{{{ Lang::get('button.update') }}}</button>
        </div>
    </div>
{{ Form::close(); }}
{{ Form::open(array('class' => 'form-horizontal')) }}
	<div class="form-group">
        <div class="col-md-offset-2 col-md-10">
		<div class="input-group-btn">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Cancel Account <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <li><a href="{{ URL::to('user/' . $user->id . '/cancel/now') }}">Immediatly</a></li>
          <li><a href="{{ URL::to('user/' . $user->id . '/cancel/later') }}">In 15 minutes</a></li>
          <li><a href="{{ URL::to('user/' . $user->id . '/cancel/tomorrow') }}">Tomorrow</a></li>
        </ul>
      </div>
							
		</div>
    </div>
{{ Form::close(); }}
<hr/>
@stop
