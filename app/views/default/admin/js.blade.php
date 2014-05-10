	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="{{{ asset('assets/js/bootstrap-wysiwyg-start.js') }}}"></script>
	<script src="{{{ URL::to('translation.js') }}}"></script>
	<script src="{{{ asset('assets/js/jquery.poller.js') }}}"></script>
	<script type="text/javascript">
		/* setup poller with the url */
		$.fn.poller({'url':'{{{ URL::to("admin/polling") }}}'});
	</script>

	<script src="//cdn.jsdelivr.net/select2/3.4.8/select2.min.js"></script>

	<script src="{{{ asset('assets/js/site.js') }}}"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
	<script src="{{{ asset('assets/js/datatables.fnReloadAjax.js') }}}"></script>
	<script src="{{{ asset('assets/js/datatables-bootstrap.js') }}}"></script>
	<script src="{{{ asset('assets/js/datatables.js') }}}"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.2.0/bootbox.min.js"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>