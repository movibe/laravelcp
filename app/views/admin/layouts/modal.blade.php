 @yield('styles')
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{ $title }}</h4>
		@yield('model-subtitle')
		<div class="pull-right">
			@yield('model-buttons')
		</div>
      </div>
      <div class="modal-body">
		@yield('content')
		@include('notifications')
      </div>
  </div>
 @yield('scripts')
 
<script type="text/javascript">
	/* STILL TESTING!!! close dialogs on back button in phones */
	var bajb_backdetect={Version:'1.0.0',Description:'Back Button Detection',Browser:{IE:!!(window.attachEvent&&!window.opera),Safari:navigator.userAgent.indexOf('Apple')>-1,Opera:!!window.opera},FrameLoaded:0,FrameTry:0,FrameTimeout:null,OnBack:function(){alert('Back Button Clicked')},BAJBFrame:function(){var BAJBOnBack=document.getElementById('BAJBOnBack');if(bajb_backdetect.FrameLoaded>1){if(bajb_backdetect.FrameLoaded==2){bajb_backdetect.OnBack();history.back()}}bajb_backdetect.FrameLoaded++;if(bajb_backdetect.FrameLoaded==1){if(bajb_backdetect.Browser.IE){bajb_backdetect.SetupFrames()}else{bajb_backdetect.FrameTimeout=setTimeout("bajb_backdetect.SetupFrames();",700)}}},SetupFrames:function(){clearTimeout(bajb_backdetect.FrameTimeout);var BBiFrame=document.getElementById('BAJBOnBack');var checkVar=BBiFrame.src.substr(-11,11);if(bajb_backdetect.FrameLoaded==1&&checkVar!="HistoryLoad"){BBiFrame.src="blank.html?HistoryLoad"}else{if(bajb_backdetect.FrameTry<2&&checkVar!="HistoryLoad"){bajb_backdetect.FrameTry++;bajb_backdetect.FrameTimeout=setTimeout("bajb_backdetect.SetupFrames();",700)}}},SafariHash:'false',Safari:function(){if(bajb_backdetect.SafariHash=='false'){if(window.location.hash=='#b'){bajb_backdetect.SafariHash='true'}else{window.location.hash='#b'}setTimeout("bajb_backdetect.Safari();",100)}else if(bajb_backdetect.SafariHash=='true'){if(window.location.hash==''){bajb_backdetect.SafariHash='back';bajb_backdetect.OnBack();history.back()}else{setTimeout("bajb_backdetect.Safari();",100)}}},Initialise:function(){if(bajb_backdetect.Browser.Safari){setTimeout("bajb_backdetect.Safari();",600)}else{document.write('<iframe src="blank.html" style="display:none;" id="BAJBOnBack" onunload="alert(\'de\')" onload="bajb_backdetect.BAJBFrame();"></iframe>')}}};bajb_backdetect.Initialise();
	bajb_backdetect.OnBack = function(){
		bootbox.hideAll();
		$('#site-modal').modal('hide');
		window.stop();
		if ($.browser.msie) {document.execCommand("Stop");};
		return false;
	}
</script>


