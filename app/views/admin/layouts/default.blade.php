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

	<div class="visible-xs modal-backdrop mobile-loading">loading...</div>

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

		$('.mobile-loading').removeClass('visible-xs').hide();

		/* close dialogs on back button in phones */
		var bajb_backdetect={Version:'1.0.0',Description:'Back Button Detection',Browser:{IE:!!(window.attachEvent&&!window.opera),Safari:navigator.userAgent.indexOf('Apple')>-1,Opera:!!window.opera},FrameLoaded:0,FrameTry:0,FrameTimeout:null,OnBack:function(){alert('Back Button Clicked')},BAJBFrame:function(){var BAJBOnBack=document.getElementById('BAJBOnBack');if(bajb_backdetect.FrameLoaded>1){if(bajb_backdetect.FrameLoaded==2){bajb_backdetect.OnBack();history.back()}}bajb_backdetect.FrameLoaded++;if(bajb_backdetect.FrameLoaded==1){if(bajb_backdetect.Browser.IE){bajb_backdetect.SetupFrames()}else{bajb_backdetect.FrameTimeout=setTimeout("bajb_backdetect.SetupFrames();",700)}}},SetupFrames:function(){clearTimeout(bajb_backdetect.FrameTimeout);var BBiFrame=document.getElementById('BAJBOnBack');var checkVar=BBiFrame.src.substr(-11,11);if(bajb_backdetect.FrameLoaded==1&&checkVar!="HistoryLoad"){BBiFrame.src="blank.html?HistoryLoad"}else{if(bajb_backdetect.FrameTry<2&&checkVar!="HistoryLoad"){bajb_backdetect.FrameTry++;bajb_backdetect.FrameTimeout=setTimeout("bajb_backdetect.SetupFrames();",700)}}},SafariHash:'false',Safari:function(){if(bajb_backdetect.SafariHash=='false'){if(window.location.hash=='#b'){bajb_backdetect.SafariHash='true'}else{window.location.hash='#b'}setTimeout("bajb_backdetect.Safari();",100)}else if(bajb_backdetect.SafariHash=='true'){if(window.location.hash==''){bajb_backdetect.SafariHash='back';bajb_backdetect.OnBack();history.back()}else{setTimeout("bajb_backdetect.Safari();",100)}}},Initialise:function(){if(bajb_backdetect.Browser.Safari){setTimeout("bajb_backdetect.Safari();",600)}else{document.write('<iframe src="blank.html" style="display:none;" id="BAJBOnBack" onunload="alert(\'de\')" onload="bajb_backdetect.BAJBFrame();"></iframe>')}}};bajb_backdetect.Initialise();
		bajb_backdetect.OnBack = function(){
			bootbox.hideAll();
			window.stop();
			if ($.browser.msie) {document.execCommand("Stop");};
			return false;
		}

    </script>
</body>
</html>