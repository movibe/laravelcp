@extends(Theme::path('admin/layouts/modal'))

@section('title')
	@if (isset($role))
	{{{ Lang::get('admin/roles/title.role_update') }}}
	@else
	{{{ Lang::get('admin/roles/title.create_a_new_role') }}}
	@endif
@stop

@section('content')
	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#roles').html()){
			var oTable = parent.$('#roles').dataTable();
			oTable.fnReloadAjax();
		}
		closeModel();
	</script>
	@else

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
		<li><a href="#tab-permissions" data-toggle="tab">{{{ Lang::get('core.permissions') }}}</a></li>
	</ul>

	@if (isset($role))
		{{ Form::open_horizontal(array('method' => 'put','url' => URL::to('admin/roles/' . $role->id . '/edit'),'class' => 'form-ajax')) }}
	@else
		{{ Form::open_horizontal(array('method' => 'post','class' => 'form-ajax')) }}
	@endif


		<div class="tab-content">


			<div class="tab-pane active" id="tab-general">
				{{ Form::input_group('text', 'name', Lang::get('core.name'), Input::old('name', isset($role) ? $role->name : null), $errors, array('maxlength'=>'70','required'=>'required')) }}
				
				{{ Form::select_group('access',  Lang::get('core.access'),
					array(
						'' => '',
						'client' => 'client',
						'admin' => 'admin',
						),
						isset($role) ? $role->access : null, $errors) }} 	
			</div>

			<div class="tab-pane" id="tab-permissions">
				<p><button class="btn btn-success" onclick="$('.permission-list').find(':checkbox').prop('checked', true);return false;">{{{ Lang::get('core.all') }}}</button></p>
				<ul class="permission-list list-group checked-list-box">
					@foreach ($permissions as $index => $permission)
						<li class="list-group-item">
							<input type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" />
							<input type="checkbox" id="permissions{{{ $permission['id'] }}}" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true) ? ' checked' : ''}}} />
							<label for="permissions{{{ $permission['id'] }}}">{{{ $permission['display_name'] }}}</label>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")) }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')) }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')) }} 
		</div>

	{{ Form::close() }}
	@endif
@stop