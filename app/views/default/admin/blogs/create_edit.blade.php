@extends(Theme::path('admin/layouts/modal'))

@section('content')
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
		<li><a href="#tab-meta-data" data-toggle="tab">{{{ Lang::get('admin/slugs.meta_data') }}}</a></li>
		<li><a href="#tab-settings" data-toggle="tab">{{{ Lang::get('core.settings') }}}</a></li>
	</ul>

	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#blogs').html()){
			var oTable = parent.$('#blogs').dataTable();
			oTable.fnReloadAjax();
		}
	</script>
	@endif

	@if (isset($post))
		{{ Form::open(array('method' => 'put','url' => URL::to('admin/slugs/' . $post->id . '/edit'), 'class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html())")) }}
	@else
		{{ Form::open(array('class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html())")) }}
	@endif

		<div class="tab-content">
			<div class="tab-pane active" id="tab-general">

				<div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
						<input required placeholder="{{{ Lang::get('admin/slugs.post_title') }}}" class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
					<div class="col-md-12">
@section('wysiywg-content')
{{ Input::old('content', isset($post) ? $post->content : null) }}
@stop
						<p>@include(Theme::path('wysiwyg'))</p>

						<textarea id="wysiwyg-body" class="hide" name="content" value="content" rows="10"></textarea>
						{{ $errors->first('content', '<span class="help-block">:message</span>') }}
					</div>
				</div>

			</div>

			<div class="tab-pane" id="tab-meta-data">
				<div class="form-group {{{ $errors->has('meta-title') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-title">{{{ Lang::get('admin/slugs.meta_title') }}}</label>
						<input class="form-control" type="text" name="meta-title" id="meta-title" value="{{{ Input::old('meta-title', isset($post) ? $post->meta_title : null) }}}" />
						{{ $errors->first('meta-title', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('meta-description') ? 'has-error' : '' }}}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="meta-description">{{{ Lang::get('admin/slugs.meta_description') }}}</label>
						<input class="form-control" type="text" name="meta-description" id="meta-description" value="{{{ Input::old('meta-description', isset($post) ? $post->meta_description : null) }}}" />
						{{{ $errors->first('meta-description', '<span class="help-block">:message</span>') }}}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('meta-keywords') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-keywords">{{{ Lang::get('admin/slugs.meta_keywords') }}}</label>
						<input class="form-control" type="text" name="meta-keywords" id="meta-keywords" value="{{{ Input::old('meta-keywords', isset($post) ? $post->meta_keywords : null) }}}" />
						{{ $errors->first('meta-keywords', '<span class="help-block">:message</span>') }}
					</div>
				</div>

			</div>

			<div class="tab-pane" id="tab-settings">
				<div class="form-group {{{ $errors->has('banner') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="banner">{{{ Lang::get('admin/slugs.banner') }}}</label>
						<input class="form-control" type="text" name="banner" id="banner" value="{{{ Input::old('banner', isset($post) ? $post->banner : null) }}}" />
						{{ $errors->first('banner', '<span class="help-block">:message</span>') }}
					</div>
				</div>


				<div class="form-group {{{ $errors->has('parent') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="parent">{{{ Lang::get('core.parent') }}}</label>
						{{ Form::select('parent', $parents, Input::old('parent', isset($post) ? $post->parent : null),array('class' => 'form-control')); }}
						{{ $errors->first('parent', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('template') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="col-md-4 control-label">{{{ Lang::get('core.template') }}}</label>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="template-tag">Default</span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu template-dropdown">
								<li><a href="site.layout.default">Default</a></li>
								@foreach($templates as $id=>$var)
									@if($var->getFilename() != 'default.blade.php')
									<li><a href="site.layout.{{{ str_replace(DIRECTORY_SEPARATOR, '.',preg_replace('/.blade.php/i', '',$var->getRelativePathname())) }}}">{{{ str_replace(DIRECTORY_SEPARATOR, '.',rtrim($var->getRelativePathname(),'.blade.php')) }}}</a></li>
									@endif
								@endforeach
							</ul>
							<input type="hidden" id="template" name="template" value="site.layout.default"/>
						</div>
						{{ $errors->first('template', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<div class="form-group {{{ $errors->has('display_navigation') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="col-md-4 control-label" for="display_navigation">{{{ Lang::get('core.display_navigation') }}}</label>
						<div class="btn-group btn-toggle" data-toggle="buttons">
							<label class="btn btn-default {{(Input::old('display_navigation', isset($post) ? $post->display_navigation : null) ? 'active btn-primary' : null)}}">
								{{ Form::radio('display_navigation', '1', (Input::old('display_navigation', isset($post) ? $post->display_navigation : null) ? true : null)) }} Yes
							</label>
							<label class="btn btn-default {{(Input::old('display_navigation', isset($post) ? $post->display_navigation : null) ? null : 'active btn-primary')}}">
								{{ Form::radio('display_navigation', '0', (Input::old('display_navigation', isset($post) ? $post->display_navigation : null) ? null : true)) }} No
							</label>
						 </div>
						{{ $errors->first('display_navigation', '<span class="help-block">:message</span>') }}
					</div>
				</div>


				<div class="form-group {{{ $errors->has('display_author') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="col-md-4 control-label" for="display_author">{{{ Lang::get('core.display_author') }}}</label>
						<div class="btn-group btn-toggle" data-toggle="buttons">
							<label class="btn btn-default {{(Input::old('display_author', isset($post) ? $post->display_author : null) ? 'active btn-primary' : null)}}">
								{{ Form::radio('display_author', '1', (Input::old('display_author', isset($post) ? $post->display_author : null) ? true : null)) }} Yes
							</label>
							<label class="btn btn-default {{(Input::old('display_author', isset($post) ? $post->display_author : null) ? null : 'active btn-primary')}}">
								{{ Form::radio('display_author', '0', (Input::old('display_author', isset($post) ? $post->display_author : null) ? null : true)) }} No
							</label>
						 </div>
						{{ $errors->first('display_author', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('allow_comments') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="col-md-4 control-label" for="allow_comments">{{{ Lang::get('core.allow_comments') }}}</label>
						<div class="btn-group btn-toggle" data-toggle="buttons">
							<label class="btn btn-default {{(Input::old('allow_comments', isset($post) ? $post->allow_comments : null) ? 'active btn-primary' : null)}}">
								{{ Form::radio('allow_comments', '1', (Input::old('allow_comments', isset($post) ? $post->allow_comments : null) ? true : null)) }} Yes
							</label>
							<label class="btn btn-default {{(Input::old('allow_comments', isset($post) ? $post->allow_comments : null) ? null : 'active btn-primary')}}">
								{{ Form::radio('allow_comments', '0', (Input::old('allow_comments', isset($post) ? $post->allow_comments : null) ? null : true)) }} No
							</label>
						 </div>
						{{ $errors->first('allow_comments', '<span class="help-block">:message</span>') }}
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
@section('styles')
	<style type="text/css"> 
		#editor {
			height: 200px;
			overflow: auto;
		}
	</style>
@stop
@section('scripts')
	<script type="text/javascript">
		initToolbarBootstrapBindings();  
		$('#editor').wysiwyg({ fileUploadError: showErrorAlert, hotKeys: {}} );

		$(document).on("click", ".template-dropdown a", function(e) {
			e.preventDefault();   
			$('#template').val($(this).attr('href'));
			$('.template-tag').html($(this).html());
		});
	</script>


@stop