@extends(Theme::path('site/layouts/default'))

{{-- Content --}}
@section('content')

<br/>
<div class="jumbotron">
  <h1>LaravelCP</h1>
  <p>A modular control panel written in PHP using Laravel 4, jQuery 2, Bootstrap 3 &amp; FontAwesome 4.</p>
  <p><a href="https://github.com/gcphost/l4-bootstrap-admin" class="btn btn-primary btn-lg">Browse on Github</a> <a href="{{{ URL::to('user/create') }}}" class="btn btn-info btn-lg">Sign up</a></p>
</div>


{{ $home->content() }}
@stop