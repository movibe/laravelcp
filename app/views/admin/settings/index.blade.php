@extends('admin.layouts.default')

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('content')
	<div class="page-header">
		<h3>{{{ $title }}}</h3>
	</div>

	{{ Form::open(array('class' => 'form-horizontal')) }}
		 @foreach($settings as $a => $b)
		 @if (is_array($b))
				@section('tabs')
					<li><a href="#{{{ $a }}}" data-toggle="tab">
						@if (Lang::has('core::all.'.$a)){{ trans('core::all.'.$a) }}@else{{ $a }}@endif
					</a></li>
				@stop
			
				@section('tab-content')
					<div class="tab-pane fade in active" id="{{{ $a }}}">
					<table width="80%" class="table table-striped table-hover">
					@foreach($b as $c => $d)
							<tr>
								  <td><label class="control-label">@if (Lang::has('core::all.'.$c)){{ trans('core::all.'.$c) }}@else{{ $c }}@endif</label></td>
								  <td><input class="col-lg-12 form-control" type="text" name="settings[{{ $a }}.{{ $c }}]" value="{{ $d }}"></td>
							</tr>
					 @endforeach
					</table>
					</div>
				@stop
		@endif
		@endforeach

		<ul class="nav nav-tabs">@yield('tabs')</ul>
		<div class="tab-content">@yield('tab-content')</div>

		<div class="form-group">
			<div class="col-md-12">
				{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')); }} 
				{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-success')); }} 
			</div>
		</div>
	{{ Form::close(); }}
@stop