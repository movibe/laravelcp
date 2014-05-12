<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/bootstrap.min.css') }}}" />
@if(Setting::get('site.bootswatch'))
<link rel="stylesheet" type="text/css" href="//bootswatch.com/{{{ Setting::get('site.bootswatch') }}}/bootstrap.min.css" />
@else
<link rel="stylesheet" type="text/css" href="//bootswatch.com/assets/css/bootswatch.min.css" />
@endif
<link href="{{{ asset('assets/css/font-awesome.css') }}}" rel="stylesheet">
<link rel="stylesheet" href="{{{ asset('assets/css/select2.css') }}}">
<link rel="stylesheet" href="{{{ asset('assets/css/style.css') }}}"/>

<link rel="stylesheet" href="{{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}}"/>

@yield('styles')