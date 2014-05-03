@extends(Theme::path('admin/layouts/modal'))

@section('content')
	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#todos').html()){
			var oTable = parent.$('#todos').dataTable();
			oTable.fnReloadAjax();
		}
	</script>
	@endif

	@if (isset($todo))
		{{ Form::open(array('method' => 'put','url' => URL::to('admin/todos/' . $todo->id . '/edit'), 'class' => 'form-horizontal form-ajax')) }}
	@else
		{{ Form::open(array('class' => 'form-horizontal form-ajax')) }}
	@endif

		<div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
			<div class="col-md-12">
				<input required placeholder="{{{ Lang::get('admin/todos/todos.post_title') }}}" class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($todo) ? $todo->title : null) }}}" />
				{{ $errors->first('title', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
			<div class="col-md-12">
				<textarea rows="8" name="description" class="form-control" placeholder="{{{ Lang::get('admin/todos/todos.post_description') }}}">{{{ Input::old('description', isset($todo) ? $todo->description : null) }}}</textarea>
				{{ $errors->first('description', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-8">

				{{ Form::select('status', 
						array(
							'1' => Lang::get('admin/todos/todos.status_1'),
							'2' => Lang::get('admin/todos/todos.status_2'),
							'3' => Lang::get('admin/todos/todos.status_3'),
							'4' => Lang::get('admin/todos/todos.status_4'),
							'5' => Lang::get('admin/todos/todos.status_5')),
								Input::old('status', isset($todo) ? $todo->status : null), array('class' => 'form-control')) }} 	
				
				{{ $errors->first('status', '<span class="help-block">:message</span>') }}
			</div>
			<div class="col-md-4">
				<div class="input-group date" id="datetimepicker1">
					<input name="due_at" type="text" class="form-control" placeholder="{{{ Lang::get('core.due_at') }}}" 
					{{ $due = preg_replace('/0000-00-00 00:00:00/i', '',Input::old('due_at', isset($todo) ? $todo->due_at : null))}}
					value="{{ $due ? date('m/d/Y g:i A', strtotime($due)) : null }}"/>
					<span class="input-group-addon"><span class="fa fa-calendar"></span>
					</span>
					{{ $errors->first('due_at', '<span class="help-block">:message</span>') }}
				</div>
			</div>
        </div>
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
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")); }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')); }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')); }} 
		</div>
	{{ Form::close(); }}
@stop
