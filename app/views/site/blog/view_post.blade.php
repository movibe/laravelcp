@extends('site.layouts.default')

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

<a href="{{{ $post->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>


<div class="clearfix">
<div class="pull-left"><img alt="{{{ $post->author->email }}}" src="{{ Gravatar::src($post->author->email, 80) }}"></div>
<div class="pull-left"><h1>{{ $post->title }}</h1>
<div>By {{ $post->author->displayname }}, Posted {{{ $post->date() }}}</div>
</div>
</div>

<hr />

<div class="panel panel-default">
  <div class="panel-body">
  <p>{{ $post->content() }}</p>
</div></div>



<hr />

<a id="comments"></a>
<h4>{{{ $comments->count() }}} Comments</h4>

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
<div class="alert alert-danger">
<p>You need to be logged in to add comments.<br /><br />
Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account. If you don't have an account click <a href="{{{ URL::to('user/create') }}}">here</a> to sign up.
</div>


@elseif ( ! $canComment )
You don't have the correct permissions to add comments.</p>
@else

@if($errors->has())
<div class="alert alert-danger alert-block">
<ul>
@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<h4>Add a Comment</h4>
<form  method="post" action="{{{ URL::to($post->slug) }}}">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

	<textarea class="col-md-12 input-block-level" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>

	<div class="form-group">
		<div class="col-md-12">
			<input type="submit" class="btn btn-default" id="submit" value="Submit" />
		</div>
	</div>
</form>
@endif
@stop
