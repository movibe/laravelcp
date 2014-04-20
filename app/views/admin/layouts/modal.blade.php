<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
		@section('title')
			{{{ $title }}} :: {{{ Lang::get('core.administration') }}}
		@show
	</title>

	<meta name="keywords" content="@yield('keywords')" />
	<meta name="author" content="@yield('author')" />
	<meta name="description" content="@yield('description')" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

	<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
	<script src="//code.jquery.com/jquery-latest.min.js"></script>

	@include('admin/css')


	<style type="text/css">
		.tab-pane {
			padding-top: 20px;
		}
		.page-header, .container, body{ margin-top: 0px; padding-top:0px;}
	</style>

	@yield('styles')

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="container" style="display:none">
		@include('notifications')

		<div class="page-header">
			<h3>
				{{ $title }}
				@yield('model-subtitle')
				<div class="pull-right">
					@yield('model-buttons')
				</div>
			</h3>
		</div>

		@yield('content')

		<footer class="clearfix">
			@yield('footer')
		</footer>

	</div>

	@include('admin/js')

 
 
<script type="text/javascript">
	$(function() {
		setTimeout(function(){
			parent.modalfyIframes();
			$('.container').show();

		}, 300);
		//$('.wysihtml5').summernote();
		$(prettyPrint)
	});
</script>

@yield('scripts')

</body>
</html>