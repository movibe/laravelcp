@extends(Theme::path('admin/layouts/modal'))

@section('title')
	{{{ Lang::get('admin/comments/title.comment_update') }}}
@stop

@section('content')

	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#comments').html()){
			var oTable = parent.$('#comments').dataTable();
			oTable.fnReloadAjax();
		}
		closeModel();
	</script>
	@else

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
	</ul>
	
	<div class="tab-content">

	{{ Form::open_horizontal(array('method' => 'put','class' => 'form-ajax')) }}

		<fieldset>

			{{ Form::textarea_group('content', '', Input::old('content', $comment->content), $errors, array('class'=>'full-width','placeholder' => Lang::get('core.content'), 'rows'=>'10', 'required'=>'required'), '', false) }} 

		</fieldset>

		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")) }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')) }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')) }} 
		</div>
	{{ Form::close() }}
	</div>
	@endif
@stop