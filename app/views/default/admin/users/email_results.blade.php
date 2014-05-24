@extends(Theme::path('admin/layouts/modal'))

@section('title')
	{{{ $title }}}
@stop

@section('content')
@if($_results)
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4>Success</h4>
		{{{ $message }}}
		<script type="text/javascript">
			closeModel();
		</script>
	</div>
@else
	<div class="alert alert-danger alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4>Error</h4>
		{{{ $message }}}
	</div>
	{{ Form::reset(Lang::get('button.close'), array('class' => 'btn btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")); }} 
@endif
@stop