@extends(Theme::path('site/layouts/default'))
@section('title')
{{{ String::title($post->title) }}} ::
@parent
@stop
@section('meta_title')
@parent
@stop
@section('meta_description')
@parent

@stop
@section('meta_keywords')
@parent

@stop

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

	{{ $commentForm }}
@endif
@stop