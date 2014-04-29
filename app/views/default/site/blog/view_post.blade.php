@extends(Theme::path('site/layouts/default'))

{{-- Web site Title --}}
@section('title')
{{{ String::title($post->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
@parent

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
@parent

@stop

{{-- Content --}}
@section('content')

@if($post->banner)<a href="{{{ $post->url() }}}" class="thumbnail"><img width="100%" src="{{{ $post->banner }}}" alt=""></a>@endif

<br/>
<div class="clearfix">
	@if($post->display_author)<div class="pull-left"><img alt="{{{ $post->author->email }}}" src="{{ Gravatar::src($post->author->email, 80) }}"></div>@endif
	<div class="pull-left" >
		<h3>&nbsp;{{ $post->title }}</h3>
		@if($post->display_author)<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;By {{ $post->author->displayname }}, {{{ Lang::get('site.posted') }}} {{{ $post->date() }}}</div>@endif
	</div>
</div>

<hr />

<div class="panel panel-default">
  <div class="panel-body">
	  <p>{{ $post->content() }}</p>
	</div>
</div>

@if($post->allow_comments)
<hr />


<a id="comments"></a>
<h4>{{{ $comments->count() }}} {{{ Lang::get('site.comments') }}}</h4>

@if ($comments->count())
@foreach ($comments as $comment)
<div class="row">
	<div class="col-md-1">
		<img alt="{{{ $comment->author->email }}}" src="{{ Gravatar::src($comment->author->email, 60) }}">
	</div>
	<div class="col-md-11">
		<div class="row">
			<div class="col-md-11">
				<span class="muted">{{{ $comment->author->displayname }}}</span>
				&bull;
				{{{ $comment->date() }}}
			</div>

			<div class="col-md-11">
				<hr />
			</div>

			<div class="col-md-11">
				{{{ $comment->content() }}}
			</div>
		</div>
	</div>
</div>
<hr />
@endforeach
@else
<hr />
@endif

@if ( ! Auth::check())
	<div class="alert alert-danger alert-block">
		<p>{{{ Lang::get('site.login_to_comment') }}}</p>
		<p>{{ Lang::get('site.comment_login', array('login' => URL::to('user/login'), 'create' => URL::to('user/create'))) }}</p>
	</div>
@elseif ( ! $canComment )
	<div class="alert alert-danger alert-block">
		<p>{{{ Lang::get('site.comment_no_perm') }}}</p>
	</div>
@else
	<div class="row">
	<form method="post" action="{{{ URL::to($post->slug) }}}">
		<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
		{{ Form::honeypot('comment_hp', 'comment_time') }}

		<div class="form-group">
			<div class="col-md-12">
				<textarea placeholder="{{{ Lang::get('site.add_comment') }}}" class="col-md-12 form-control" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<input type="submit" class="btn btn-default" id="submit" value="{{{ Lang::get('button.submit') }}}" />
			</div>
		</div>
	</form>
	</div>

@endif


@if($errors->has())
<div class="alert alert-danger alert-block">
<ul>
@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

@endif
@stop