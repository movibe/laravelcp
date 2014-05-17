@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ Lang::get('admin/settings/title.title') }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/settings'))
@stop

@section('left-layout-content')
	<div class="page-header">
		<h3>{{{ Lang::get('admin/settings/title.title') }}}</h3>
	</div>

	{{ Form::open() }}
		 @foreach($settings as $a => $b)
		 @if (is_array($b))
				@section('tabs')
					<li @if($a == 'site')class="active"@endif><a href="#{{{ $a }}}" data-toggle="tab">
						@if (Lang::has('core::all.'.$a)){{ trans('core::all.'.$a) }}@else{{ $a }}@endif
					</a></li>
				@append
			
				@section('tab-content')
					<div class="tab-pane @if($a == 'site')active@endif" id="{{{ $a }}}">
					<table width="80%" class="table table-bordered table-striped table-hover">
					@foreach($b as $c => $d)
							<tr>
								 <td><label class="control-label">{{ Lang::has('core::settings.'.$c) ? trans('core::settings.'.$c) : preg_replace('/_/i', ' ', $c) }}</label></td>
								 <td>
									@if($c == "contact_address")
										{{ Form::textarea_line('settings['. $a .'.'. $c.']', '', $d, $errors, '','',false) }} 
									@elseif($c == "bootswatch")
										{{ Form::select_basic('settings['. $a .'.'. $c.']', '',
												array(
													'default' => 'Default',
													'amelia' => 'Amelia',
													'cerulean' => 'Cerulean',
													'cosmo' => 'Cosmo',
													'cyborg' => 'Cyborg',
													'darkly' => 'Darkly',
													'flatly' => 'Flatly',
													'journal' => 'Journal',
													'lumen' => 'Lumen',
													'readable' => 'Readable',
													'simplex' => 'Simplex',
													'slate' => 'Slate',
													'spacelab' => 'Spacelab',
													'superhero' => 'Superhero',
													'united' => 'United',
													'yeti' => 'Yeti'
													),
													$d, $errors,'', '',false) }} 	
									@else
										{{ Form::input_basic('text', 'settings['. $a .'.'. $c.']', '', $d, $errors) }} 
									@endif
								</td>
							</tr>
					 @endforeach
					</table>
					</div>
				@append
		@endif
		@endforeach

		<ul class="nav nav-tabs"  style="border-bottom: 0px">@yield('tabs')</ul>
		<div class="tab-content">@yield('tab-content')</div>

		<div class="form-group">
			<div class="col-md-12">
				{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')) }} 
				{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-success')) }} 
			</div>
		</div>
	{{ Form::close() }}
@stop
@include(Theme::path('admin/layouts/sidebar-left'))