@extends(Theme::path('admin/layouts/default'))

@section('title')
	{{{ $title }}} :: @parent
@stop

@section('left-layout-nav')
	@include(Theme::path('admin/navigation/settings'))
@stop

@section('left-layout-content')
	<div class="page-header">
		<h3>{{{ $title }}}</h3>
	</div>

	{{ Form::open(array('class' => 'form-horizontal')) }}
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
										<textarea class="col-lg-12 form-control" name="settings[{{ $a }}.{{ $c }}]">{{ $d }}</textarea>
									@elseif($c == "bootswatch")
										<select class="form-control" name="settings[{{ $a }}.{{ $c }}]">
											<option value="" {{ $d=='' ? 'selected' : false }}>Default</option>
											<option value="amelia" {{ $d=='amelia' ? 'selected' : false }}>Amelia</option>
											<option value="cerulean" {{ $d=='cerulean' ? 'selected' : false }}>Cerulean</option>
											<option value="cosmo" {{ $d=='cosmo' ? 'selected' : false }}>Cosmo</option>
											<option value="cyborg" {{ $d=='cyborg' ? 'selected' : false }}>Cyborg</option>
											<option value="darkly" {{ $d=='darkly' ? 'selected' : false }}>Darkly</option>
											<option value="flatly" {{ $d=='flatly' ? 'selected' : false }}>Flatly</option>
											<option value="journal" {{ $d=='journal' ? 'selected' : false }}>Journal</option>
											<option value="lumen" {{ $d=='lumen' ? 'selected' : false }}>Lumen</option>
											<option value="readable" {{ $d=='readable' ? 'selected' : false }}>Readable</option>
											<option value="simplex" {{ $d=='simplex' ? 'selected' : false }}>Simplex</option>
											<option value="slate" {{ $d=='slate' ? 'selected' : false }}>Slate</option>
											<option value="spacelab" {{ $d=='spacelab' ? 'selected' : false }}>Spacelab</option>
											<option value="superhero" {{ $d=='superhero' ? 'selected' : false }}>Superhero</option>
											<option value="united" {{ $d=='united' ? 'selected' : false }}>United</option>
											<option value="yeti" {{ $d=='yeti' ? 'selected' : false }}>Yeti</option>
										</select>
									@else
										<input class="col-lg-12 form-control" type="text" name="settings[{{ $a }}.{{ $c }}]" value="{{ $d }}">
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
				{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')); }} 
				{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-success')); }} 
			</div>
		</div>
	{{ Form::close(); }}
@stop
@include(Theme::path('admin/left-layout'))