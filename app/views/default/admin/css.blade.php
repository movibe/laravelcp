<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css" />
@if(Setting::get('site.bootswatch'))
<link rel="stylesheet" type="text/css" href="//bootswatch.com/{{{ Setting::get('site.bootswatch') }}}/bootstrap.min.css" />
@else
<link rel="stylesheet" type="text/css" href="//bootswatch.com/assets/css/bootswatch.min.css" />
@endif
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="{{{ asset('assets/css/style.css') }}}"/>

@yield('styles')