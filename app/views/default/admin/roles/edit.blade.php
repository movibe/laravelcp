@extends(Theme::path('admin/layouts/modal'))

@section('title')
	{{{ Lang::get('admin/roles/title.role_update') }}}
@stop

@section('content')
	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#roles').html()){
			var oTable = parent.$('#roles').dataTable();
			oTable.fnReloadAjax();
		}
	</script>
	@endif

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
		<li><a href="#tab-permissions" data-toggle="tab">{{{ Lang::get('core.permissions') }}}</a></li>
	</ul>

	{{ Form::open_horizontal(array('method' => 'put','class' => 'form-ajax')) }}

		<div class="tab-content">


			<div class="tab-pane active" id="tab-general">
				{{ Form::input_group('text', 'name', Lang::get('core.name'), Input::old('name', $role->name), $errors, array('required'=>'required')) }}
				
				{{ Form::select_group('access',  Lang::get('core.access'),
					array(
						'' => '',
						'client' => 'client',
						'admin' => 'admin',
						),
						isset($role) ? $role->access : null, $errors) }} 	
			</div>

			<div class="tab-pane" id="tab-permissions">
				<div class="form-group">
					<div class="btn-group" data-toggle="buttons">
						<button class="btn btn-success" onclick="$('.btn-group').find('.btn').button('toggle')">{{{ Lang::get('core.all') }}}</button>
					</div><p></p><div class="btn-group" data-toggle="buttons">
						@foreach ($permissions as $index => $permission)
							<label class="btn btn-primary {{{ (isset($permission['checked']) && $permission['checked'] == true ? ' active' : '')}}}">
								<input type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" />
								<input  type="checkbox" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true ? ' checked' : '')}}} /></span>
								{{{ $permission['display_name'] }}}
							 </label>
							 @if ($index % 4 == 0)
								</div><p></p><div class="btn-group" data-toggle="buttons">
							 @endif
						@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")) }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')) }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')) }} 
		</div>

	{{ Form::close() }}

@stop