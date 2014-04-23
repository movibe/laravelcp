@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@foreach ($posts as $post)
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $post->url() }}}">{{ String::title($post->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				@if($post->banner)<a href="{{{ $post->url() }}}" class="thumbnail"><img src="{{{ $post->banner }}}" alt=""></a>
				@else
				<a href="{{{ $post->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180/000000/000000" alt=""></a>
				@endif

			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
				<p><a class="btn btn-mini btn-default" href="{{{ $post->url() }}}">Read more</a></p>
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					@if($post->display_author)<span class="glyphicon"><img alt="{{{ $post->author->email }}}" src="{{ Gravatar::src($post->author->email, 20) }}"></span>
					by <span class="muted">{{{ $post->author->displayname }}}</span>
					|@endif <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					@if($post->allow_comments)
						| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $post->url() }}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
					@endif
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach

{{ $posts->links() }}

@stop
