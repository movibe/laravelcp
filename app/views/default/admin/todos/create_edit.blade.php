@extends(Theme::path('admin/layouts/modal'))

@section('title')
	@if (isset($todo))
		{{{ Lang::get('admin/todos/title.update') }}}
	@else
		{{{ Lang::get('admin/todos/title.create_a_new') }}}
	@endif
@stop

@section('content')
	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#todos').html()){
			var oTable = parent.$('#todos').dataTable();
			oTable.fnReloadAjax();
		}
		closeModel()
	</script>
	@else

	@if (isset($todo))
		{{ Form::open_horizontal(array('method' => 'put','url' => URL::to('admin/todos/' . $todo->id . '/edit'),'class' => 'form-ajax')) }}
	@else
		{{ Form::open_horizontal(array('class' => 'form-ajax')) }}
	@endif

		{{ Form::input_group('text', 'title', '', Input::old('title', isset($todo) ? $todo->title : null), $errors, array('maxlength'=>'70','required'=>'required', 'placeholder'=>Lang::get('admin/todos/todos.post_title')), '', false,'') }} 

		{{ Form::textarea_group('description', '', Input::old('description', isset($todo) ? $todo->description : null), $errors, array('placeholder' => Lang::get('admin/todos/todos.post_description'), 'required'=>'required'), '', false) }} 

		<div class="col-md-7">

			{{ Form::select_basic('status', '',
					array(
						'1' => Lang::get('admin/todos/todos.status_1'),
						'2' => Lang::get('admin/todos/todos.status_2'),
						'3' => Lang::get('admin/todos/todos.status_3'),
						'4' => Lang::get('admin/todos/todos.status_4'),
						'5' => Lang::get('admin/todos/todos.status_5')),
							Input::old('status', isset($todo) ? $todo->status : null), $errors,'', '',false) }} 	

		</div>
		<div class="col-md-1"></div>
		<div class="col-md-4">

			{{ Form::input_basic('text', 'due_at', '', isset($due) ? date('m/d/Y g:i A', strtotime($due)) : null, $errors, array('id'=>'datetimepicker1','placeholder'=>Lang::get('core.due_at')), '',false,'','fa fa-calendar') }} 

		</div>
		<div class="clearfix"></div>

		<script type="text/javascript">
			$('#datetimepicker1').datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            }); 
			</script>
		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")) }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')) }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')) }} 
		</div>
	{{ Form::close() }}
	@endif
@stop