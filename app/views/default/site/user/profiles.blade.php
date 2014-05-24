@include(Theme::path('helpers/profile'))
@if(isset($profile))
	<div class="form-group">
		<div class="pull-right">
			<a data-method="delete" href="{{{ URL::to('admin/users/' . $user->id . '/profile/'.$profile->id ) }}} " class="confirm-ajax-update btn btn-danger">{{{ Lang::get('button.delete') }}} {{{ $profile->title }}} </a>
		</div>
	</div>
@endif