	<script type="text/javascript">
		var lang_areyousure='{{ Lang::get('site.areyousure') }}';
		var lang_unable_to_exec='{{ Lang::get('core.unable_to_exec') }}';
		var lang_user_logged_in='{{ Lang::get('core.user_logged_in') }}';
		var lang_success='{{ Lang::get('core.success') }}';
	</script>
	<script src="{{{ asset('assets/js/jquery.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/bootstrap.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/site.js') }}}"></script>
	<script type="text/javascript">
		$.fn.poller({'url':'{{{ URL::to("admin/polling") }}}'});
	</script>