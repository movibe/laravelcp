@extends(Theme::path('admin/layouts/modal'))

@section('content')
	@if ($message = Session::get('success'))
	<script type="text/javascript">
		var oTable = parent.$('#roles').dataTable();
		oTable.fnReloadAjax();
	</script>
	@endif

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
		<li><a href="#tab-permissions" data-toggle="tab">{{{ Lang::get('core.permissions') }}}</a></li>
	</ul>

	{{ Form::open(array('class' => 'form-horizontal form-ajax')) }}

		<div class="tab-content">
			<div class="tab-pane active" id="tab-general">
				<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
					<label class="col-md-2 control-label" for="name">{{{ Lang::get('core.name') }}}</label>
                    <div class="col-md-10">
    					<input  required class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" />
    					{{ $errors->first('name', '<span class="help-block">:message</span>') }}
                    </div>
				</div>
			</div>

			<div class="tab-pane" id="tab-permissions">
                <div class="form-group">
					<div class="btn-group" data-toggle="buttons">
						<button class="btn btn-success" onclick="$('.btn-group').find('.btn').button('toggle')">{{{ Lang::get('core.all') }}}</button>
						@foreach ($permissions as $index => $permission)
							<label class="btn btn-primary">
								<input class="control-label" type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" />
								<input class="form-control" type="checkbox" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true ? ' checked="checked"' : '')}}} />
								{{{ $permission['display_name'] }}}
							 </label>
							 @if ($index % 2 == 0)
								</div><p></p><div class="btn-group" data-toggle="buttons">
							 @endif
						@endforeach
					</div>
                </div>
	        </div>
		</div>

		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-responsive btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")); }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-responsive btn-default')); }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-responsive btn-success')); }} 
		</div>
	{{ Form::close(); }}
@stop
