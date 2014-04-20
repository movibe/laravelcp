<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />

	<title>
	@section('title')
		{{{ Lang::get('core.administration') }}}
	@show
	</title>

	<meta name="keywords" content="@yield('keywords')"/>
	<meta name="author" content="@yield('author')"/>
	<meta name="description" content="@yield('description')"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta name="csrf-token" content="{{{ csrf_token() }}}"/>
	<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}"/>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}"/>
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}"/>
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}"/>
	<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}"/>

	@include('admin/css')

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	@include('admin/navigation')

	@yield('breadcrumb')

	@include('notifications')
	
	<div class="container-fluid">
		@yield('content')
	</div>
	
	<footer class="clearfix">
		@yield('footer')
	</footer>

	@include('admin/js')

    <script type="text/javascript">
        $(prettyPrint);
		fnRunPoll();
    </script>
</body>
</html>