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
{{ Form::open_horizontal(array('autocomplete' => 'off','url' => URL::to('user/' . $user->id . '/edit'))) }}
<div class="tab-content">
	<div class="tab-pane active" id="tab-general">

		{{ Form::input_group('text', 'displayname', Lang::get('core.fullname'), $user->displayname, $errors, array('maxlength'=>'70','required'=>'required'), '', true,'', 'fa fa-fw fa-user') }} 

		{{ Form::input_group('email', 'email', Lang::get('confide::confide.e_mail'), $user->email, $errors, array('maxlength'=>'254','required'=>'required'), '', true,'', 'fa fa-fw fa-envelope') }} 
		
		{{ Form::input_group('password', 'password', Lang::get('confide::confide.password'), '', $errors, '', '', true,'', 'fa fa-fw fa-lock') }} 

		{{ Form::input_group('password', 'password_confirmation', Lang::get('confide::confide.password_confirmation'), '', $errors, '', '', true,'', 'fa fa-fw fa-lock') }} 

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
				@include(Theme::path('site/user/profiles'))
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
{{ Form::close() }}

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