	<div class="alert alert-danger alert-block">
		<p>{{{ Lang::get('site.login_to_comment') }}}</p>
		<p>{{ Lang::get('site.comment_login', array('login' => URL::to('user/login'), 'create' => URL::to('user/create'))) }}</p>
	</div>
